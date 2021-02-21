<?php

namespace VRag\NotifierBundle\Service\Operator;

use Symfony\Component\Mime\Email;
use VRag\NotifierBundle\Service\Manager;
use VRag\NotifierBundle\Service\NotificationInterface;

class EmailOperator extends AbstractOperatorDecorator implements OperatorInterface
{
    use TransportTrait;

    /**
     * @var Email
     */
    protected $email;

    /**
     * @inheritdoc
     */
    public function __construct(Manager $manager, AbstractOperatorDecorator $operator = null)
    {
        parent::__construct($manager, $operator);

        $this->email = new Email();
    }

    /**
     * @param NotificationInterface $notification
     * @return EmailOperator
     */
    public function setNotification(NotificationInterface $notification): OperatorInterface
    {
        $this->email->html($notification->getContent());

        return $this;
    }

    /**
     * @param $recipients
     * @return EmailOperator
     */
    public function setRecipients($recipients): self
    {
        foreach ((array)$recipients as $recipient)
        {
            $this->email->addTo($recipient);
        }

        return $this;
    }

    /**
     * @param array|null $options
     * @return EmailOperator
     */
    public function setOptions(?array $options): self
    {
        $options = array_intersect_key($options, array_flip([
            'subject',
            'cc',
            'bcc',
            'from',
            'replyTo',
            'attach',
        ]));

        foreach ($options as $option => $value) {
            if (!method_exists($this, $option)) {
                continue;
            }
            $this->$option($value);
        }

        return $this;
    }

    /**
     * @param string|null $subject
     * @return $this
     */
    private function subject(?string $subject): self
    {
        $this->email->subject($subject);

        return $this;
    }

    /**
     * @param array $addresses
     * @param string $function
     * @return $this
     */
    private function applyAddresses($addresses, string $function)
    {
        foreach ((array)$addresses as $address) {
            $this->email->$function($address);
        }

        return $this;
    }

    /**
     * @param $addresses
     * @return $this
     */
    private function cc($addresses): self
    {
        return $this->applyAddresses($addresses, 'addCc');
    }

    /**
     * @param $addresses
     * @return $this
     */
    private function bcc($addresses): self
    {
        return $this->applyAddresses($addresses, 'addBcc');
    }

    /**
     * @param $addresses
     * @return $this
     */
    private function from($addresses): self
    {
        return $this->applyAddresses($addresses, 'addFrom');
    }

    /**
     * @param $addresses
     * @return $this
     */
    private function replyTo($addresses): self
    {
        return $this->applyAddresses($addresses, 'addReplyTo');
    }

    /**
     * @param $attachments
     * @return $this
     */
    private function attach($attachments)
    {
        foreach ($attachments as $attachment) {
            if (!isset($attachment['body'])) {
                continue;
            }

            $this->email->attach(
                $attachment['body'],
                $attachment['name'] ?? null,
                $attachment['contentType'] ?? null
            );
        }

        return $this;
    }

    /**
     * @return void
     */
    public function deliver(): void
    {
        parent::deliver();

        $this->getTransport()->deliver($this->email, $this->errors);
    }
}
