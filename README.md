notifier-bundle
=====================
Symfony 4 bundle for sending notifications

Requirements
-----------------------------------
* Php 7.4
* Symfony 4 application
***
Installation
-----------------------------------
1. Add a repository to the repositories section in your composer.json file
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/vraginya/notifier-bundle.git"
    }
]
```
2. Add the bundle to your project :
```bash
composer require vrag/notifier:dev-master
```
***
Set up
-----------------------------------
1. Put ***v_rag_notifier.yaml*** file to the directory _config/packages_ in yor symfony 4 application:
```yaml
v_rag_notifier:

  email:
    # Set the sms transport service
    transport: 'vrag_notifier.mailer_transport'

  sms:
    # Set the sms transport service (live blank if not required)
    transport: 'vrag_notifier.twilio_transport'

  twilio:
    # Twilio SID (live blank if not required)
    sid: '%env(TWILIO_SID)%'
    # Twilio Token (live blank if not required)
    token: '%env(TWILIO_TOKEN)%'
```
2. Define the bundle in the ***config/bundles.php*** file:
```php
<?php

return [
    //~~~
    VRag\NotifierBundle\VRagNotifierBundle::class => ['all' => true],
    //~~~
];

```
***
Basic usage
-----------------------------------
####Fluent interface
```php
<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use VRag\NotifierBundle\Service\Manager;
use VRag\NotifierBundle\Service\Notification;

class TestCommand extends Command
{
    protected static $defaultName = 'Test';

    private $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;

        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $notification = new Notification('HELLO WORLD!');

        $operator = $this->manager
            ->getOperator(Manager::EMAIL)
            ->setNotification($notification)
            ->setRecipients('sample@mail.com')
            ->setOptions([
                'subject' => 'Test subject',
                'from' => 'sample@mail.com',
            ])
            ->getOperator(Manager::SMS)
            ->setNotification($notification)
            ->setRecipients('+12345555555')
            ->setOptions(['from' => '+12344444444']);

        $operator->deliver();

        $output->write(print_r($operator->getErrors()));

        return 0;
    }
}
```
####Setting parameters
```php
<?php
    // ***
    $notification = new Notification('HELLO WORLD!');
    $this->manager->getOperator(
        Manager::EMAIL,
        $notification,
        ['sample@mail.com','sample2@mail.com'],
        [
            'subject' => 'Test subject',
            'from' => 'sample3@mail.com',
            'cc' => 'sample4@mail.com'
        ]
    )->deliver();

    $operator = $this->manager->getOperator(
        Manager::SMS,
        $notification,
        '+12345555555',
        ['from' => '+12344444444']
    );
    $operator->deliver();
    // ***
```
