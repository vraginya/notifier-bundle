<?php

namespace VRag\NotifierBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('v_rag_notifier');
        $rootNode
            ->children()
                ->arrayNode('email')
                    ->children()
                        ->scalarNode('transport')
                            ->defaultValue('vrag.notifier.transport.mailer')
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('sms')
                    ->children()
                        ->scalarNode('transport')->end()
                    ->end()
                ->end()
                ->arrayNode('twilio')
                    ->children()
                        ->scalarNode('sid')->end()
                        ->scalarNode('token')->end()
                    ->end()
                ->end()
            ->end();
        return $treeBuilder;
    }
}
