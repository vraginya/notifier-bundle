<?php

namespace VRag\NotifierBundle\Service\Builder;

use VRag\NotifierBundle\Service\NotificationInterface;

interface NotificationBuilderInterface
{
    /**
     * @param string $template
     * @param array $params
     * @return NotificationInterface
     */
    public function build(string $template, array $params = []): NotificationInterface;
}
