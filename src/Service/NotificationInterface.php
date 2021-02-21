<?php

namespace VRag\NotifierBundle\Service;

interface NotificationInterface
{
    /**
     * @param string $content
     * @return $this
     */
    public function setContent(string $content);

    /**
     * @return string
     */
    public function getContent(): string;
}
