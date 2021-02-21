<?php

namespace VRag\NotifierBundle\Service\Transport\Sms;

use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;
use VRag\NotifierBundle\Exceptions\BadSmsPackageException;
use VRag\NotifierBundle\Service\ErrorsTrait;
use VRag\NotifierBundle\Service\Package\Sms;

final class TwilioTransport implements SmsTransportInterface
{
    use ErrorsTrait;

    /**
     * @var Client
     */
    private $client;

    public function __construct($sid, $token)
    {
        $this->client = new Client($sid, $token);
    }

    /**
     * @inheritdoc
     */
    public function deliver($package, &$errors = []): bool
    {
        try {
            if (!$package instanceof Sms) {
                throw new BadSmsPackageException();
            }

            foreach ($package->getRecipients() as $recipient)
                /**
                 * @var Sms $package
                 */
                $this->client->messages->create(
                    $recipient,
                    [
                        'from' => $package->getFrom(),
                        'body' => $package->getBody(),
                    ]
                );
        } catch (TwilioException $e) {
            $this->addErrors($e->getMessage());
            $errors = array_merge($this->getErrors());

            return false;
        }

        return true;
    }
}
