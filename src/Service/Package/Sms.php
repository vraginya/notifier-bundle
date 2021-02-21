<?php

namespace VRag\NotifierBundle\Service\Package;

use VRag\NotifierBundle\Exceptions\BadSmsBodyException;
use VRag\NotifierBundle\Exceptions\BadSmsRecipientsException;
use VRag\NotifierBundle\Exceptions\BadSmsSenderException;

class Sms
{
    protected $recipients = [];
    protected $body;
    protected $from;

    /**
     * @param $recipients
     * @return $this
     * @throws BadSmsRecipientsException
     */
    public function setRecipients($recipients): self
    {
        if (is_string($recipients)) {
            $this->recipients[] = $recipients;
        } elseif (is_array($recipients)) {
            foreach ($recipients as $recipient) {
                if (!is_string($recipient)) {
                    throw new BadSmsRecipientsException();
                }
                $this->recipients[] = $recipient;
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * @param string $body
     * @return $this
     * @throws BadSmsBodyException
     */
    public function setBody(string $body): self
    {
        if (!is_string($body)) {
            throw new BadSmsBodyException();
        }

        $this->body = $body;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getBody(): ?string
    {
        return $this->body;
    }

    /**
     * @param string $from
     * @return $this
     * @throws BadSmsSenderException
     */
    public function setFrom(string $from): self
    {
        if (!is_string($from)) {
            throw new BadSmsSenderException();
        }

        $this->from = $from;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }
}
