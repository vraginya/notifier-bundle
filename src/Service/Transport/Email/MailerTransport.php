<?php

namespace VRag\NotifierBundle\Service\Transport\Email;

use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use VRag\NotifierBundle\Exceptions\BadEmailPackageException;
use VRag\NotifierBundle\Service\ErrorsTrait;

final class MailerTransport implements EmailTransportInterface
{
    use ErrorsTrait;

    /**
     * @var MailerInterface
     */
    protected $mailer;

    /**
     * EmailTransport constructor.
     * @param MailerInterface $mailer
     */
    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    /**
     * @inheritdoc
     */
    public function deliver($package, &$errors = []): bool
    {
        try {
            if (!$package instanceof Email) {
                throw new BadEmailPackageException();
            }

            $this->mailer->send($package);

        } catch (\Exception $e) {
            $this->addErrors($e->getMessage());
            $errors = array_merge($this->getErrors());

            return false;
        }

        return true;
    }
}
