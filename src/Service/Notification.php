<?php

namespace VRag\NotifierBundle\Service;

class Notification implements NotificationInterface
{
    /**
     * @var string
     */
    private $content;

    /**
     * Notification constructor.
     * @param string $content
     */
    public function __construct(string $content)
    {
        $this->setContent($content);
    }

    /**
     * @inheritdoc
     */
    public function setContent(string $content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
