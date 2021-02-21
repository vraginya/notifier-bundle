<?php

namespace VRag\NotifierBundle\Service\Operator;

use VRag\NotifierBundle\Service\NotificationInterface;
use VRag\NotifierBundle\Service\Transport\TransportInterface;

interface OperatorInterface
{
    /**
     * @param $recipients
     * @return $this
     */
    public function setRecipients($recipients): OperatorInterface;

    /**
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options): OperatorInterface;

    /**
     * @param NotificationInterface $notification
     * @return $this
     */
    public function setNotification(NotificationInterface $notification): OperatorInterface;

    /**
     * @param TransportInterface $transport
     * @return $this
     */
    public function setTransport(TransportInterface $transport): OperatorInterface;

    /**
     * @return void
     */
    public function deliver(): void;
}
