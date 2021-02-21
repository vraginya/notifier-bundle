<?php

namespace VRag\NotifierBundle\Service\Builder;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use VRag\NotifierBundle\Service\Notification;
use VRag\NotifierBundle\Service\NotificationInterface;

class TwigNotificationBuilder implements NotificationBuilderInterface
{
    /**
     * @var Environment
     */
    private $twig;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @param string $template
     * @param array $params
     * @return NotificationInterface
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function build(string $template, array $params = []): NotificationInterface
    {
        $content = $this->twig->render($template, $params);
        $notification = new Notification($content);

        return $notification;
    }
}
