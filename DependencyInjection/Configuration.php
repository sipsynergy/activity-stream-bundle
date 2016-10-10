<?php

namespace Sipsynergy\ActivityStreamBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This class defines the configuration information for the bundle
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('sipsynergy_activity_stream');

        $rootNode
            ->addDefaultsIfNotSet()
            ->children()
                //->scalarNode('db_driver')->defaultValue('orm')->end()
                ->arrayNode('renderer')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('default_class')->defaultValue('Sipsynergy\ActivityStreamBundle\Streamable\Renderer\DefaultRenderer')->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
