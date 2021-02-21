<?php

namespace VRag\NotifierBundle\Service\Operator;

use VRag\NotifierBundle\Exceptions\BadSmsSenderException;
use VRag\NotifierBundle\Service\Manager;
use VRag\NotifierBundle\Service\NotificationInterface;
use VRag\NotifierBundle\Service\Package\Sms;

class SmsOperator extends AbstractOperatorDecorator implements OperatorInterface
{
    use TransportTrait;

    /**
     * @var Sms
     */
    protected $sms;

    public function __construct(Manager $manager, AbstractOperatorDecorator $operator = null)
    {
        parent::__construct($manager, $operator);

        $this->sms = new Sms();
    }

    /**
     * @inheritdoc
     */
    public function setRecipients($recipients): OperatorInterface
    {
        $this->sms->setRecipients($recipients);

        return $this;
    }

    /**
     * @param array $options
     * @return OperatorInterface
     * @throws BadSmsSenderException
     */
    public function setOptions(array $options): OperatorInterface
    {
        $options = array_intersect_key($options, array_flip([
            'from',
        ]));

        if (!empty($options['from'])) {
            $this->sms->setFrom($options['from']);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function setNotification(NotificationInterface $notification): OperatorInterface
    {
        $this->sms->setBody($notification->getContent());

        return $this;
    }

    /**
     * @return void
     */
    public function deliver(): void
    {
        parent::deliver();

        $this->getTransport()->deliver($this->sms, $this->errors);
    }
}
