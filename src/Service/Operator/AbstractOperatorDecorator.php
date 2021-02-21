<?php

namespace VRag\NotifierBundle\Service\Operator;

use VRag\NotifierBundle\Exceptions\OperatorNotExistsException;
use VRag\NotifierBundle\Exceptions\TransportNotExistsException;
use VRag\NotifierBundle\Service\ErrorsTrait;
use VRag\NotifierBundle\Service\Manager;
use VRag\NotifierBundle\Service\NotificationInterface;

abstract class AbstractOperatorDecorator implements OperatorInterface
{
    use ErrorsTrait;

    private $operator;
    private $manager;

    /**
     * AbstractOperatorDecorator constructor.
     * @param Manager $manager
     * @param AbstractOperatorDecorator|null $operator
     */
    public function __construct(Manager $manager, AbstractOperatorDecorator $operator = null)
    {
        $this->manager = $manager;
        $this->operator = $operator;
    }

    /**
     * @param string $type
     * @param NotificationInterface|null $notification
     * @param null $recipients
     * @param array $options
     * @return AbstractOperatorDecorator
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
        return $this->manager->getOperator($type, $notification, $recipients, $options)->setOperator($this);
    }

    /**
     * @param AbstractOperatorDecorator $operator
     * @return $this
     */
    protected function setOperator(AbstractOperatorDecorator $operator): self
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Delivers notification
     */
    public function deliver(): void
    {
        if ($this->operator instanceof AbstractOperatorDecorator) {
            $this->operator->deliver();
            $this->addErrors($this->operator->getErrors());
        }
    }
}
