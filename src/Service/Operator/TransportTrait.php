<?php

namespace VRag\NotifierBundle\Service\Operator;

use VRag\NotifierBundle\Service\Transport\TransportInterface;

trait TransportTrait
{
    protected $transport;

    /**
     * @param TransportInterface $transport
     * @return OperatorInterface
     */
    public function setTransport(TransportInterface $transport): OperatorInterface
    {
        $this->transport = $transport;

        return $this;
    }

    /**
     * @return TransportInterface|null
     */
    public function getTransport(): ?TransportInterface
    {
        return $this->transport;
    }
}
