<?php

namespace VRag\NotifierBundle\DependencyInjection;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;

class VRagNotifierExtension extends Extension
{
    /**
     * @inheritdoc
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $this->processConfiguration($configuration, $configs);

        $loader = new YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('vrag_notifier.manager');
        $definition->setArguments([
            !empty($config['email']['transport']) ? new Reference($config['email']['transport']) : null,
            !empty($config['sms']['transport']) ? new Reference($config['sms']['transport']) : null,
        ]);

        $container->setParameter('twilio_sid', $config['twilio']['sid']);
        $container->setParameter('twilio_token', $config['twilio']['token']);
    }
}
