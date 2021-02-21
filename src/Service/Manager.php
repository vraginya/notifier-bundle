<?php

namespace VRag\NotifierBundle\Service;

use VRag\NotifierBundle\Exceptions\OperatorNotExistsException;
use VRag\NotifierBundle\Exceptions\TransportNotExistsException;
use VRag\NotifierBundle\Service\Operator\AbstractOperatorDecorator;
use VRag\NotifierBundle\Service\Operator\OperatorInterface;
use VRag\NotifierBundle\Service\Transport\Email\EmailTransportInterface;
use VRag\NotifierBundle\Service\Transport\Sms\SmsTransportInterface;

class Manager
{
    public const EMAIL = 'email';
    public const SMS = 'sms';

    protected const OPERATOR_NAMESPACE = 'VRag\NotifierBundle\Service\Operator\\';

    protected $transports = [];

    public function __construct(
        EmailTransportInterface $emailTransport = null,
        SmsTransportInterface $smsTransport = null
    )
    {
        $this->transports = [
            self::EMAIL => $emailTransport,
            self::SMS => $smsTransport,
        ];
    }

    /**
     * @param string $type
     * @param NotificationInterface|null $notification
     * @param null $recipients
     * @param array $options
     * @return OperatorInterface
     * @throws OperatorNotExistsException
     * @throws TransportNotExistsException
     */
    public function getOperator(
        string $type,
        NotificationInterface $notification = null,
        $recipients = null,
        array $options = []
    ): AbstractOperatorDecorator
    {
        $operatorClassName = self::OPERATOR_NAMESPACE . ucfirst(strtolower($type)) . 'Operator';
        if (!class_exists($operatorClassName)) {
            throw new OperatorNotExistsException();
        }

        if (empty($this->transports[$type])) {
            throw new TransportNotExistsException();
        }

        $operator = new $operatorClassName($this);
        $operator->setTransport($this->transports[$type]);

        if (!empty($notification)) {
            $operator->setNotification($notification);
        }

        if (!empty($recipients)) {
            $operator->setRecipients($recipients);
        }

        if (!empty($options)) {
            $operator->setOptions($options);
        }

        return $operator;
    }
}
