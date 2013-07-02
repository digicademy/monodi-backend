<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('digitalwert_monodi_common');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.
        $this->addGitSection($rootNode);
        $this->addExistDbSection($rootNode);
        
        return $treeBuilder;
    }
    
    /**
     * 
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $rootNode
     */
    private function addGitSection(ArrayNodeDefinition $rootNode) {
        $rootNode
            ->children()
                ->arrayNode('git')
//                    ->canBeDisabled()
                    ->info('form configuration')
                    ->children()
                        ->arrayNode('remote')
                            ->children()
                                ->scalarNode('uri')
                                    ->example('git@github.com:foo/bar')
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('local')
                            ->canBeDisabled()
                            ->children()
                                ->scalarNode('base')->defaultValue('%kernel.root_dir%/../git')->end()
                            ->end()
                        ->end()
                        ->arrayNode('ssh')
                            ->children()
                                ->scalarNode('cmd')->defaultValue('/usr/bin/ssh')->end()
                                ->scalarNode('key_file')->defaultValue(null)->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
    
    /**
     * Konfiguration für die ExistDb Connection
     * 
     * @param \Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition $rootNode
     */
    private function addExistDbSection(ArrayNodeDefinition $rootNode) {
        $rootNode
            ->children()
                ->arrayNode('existdb')
                    ->canBeDisabled()
                    ->info('form configuration')
                    ->children()
                        ->scalarNode('uri')->defaultValue('http://localohost:8080/')->end()
                        ->scalarNode('collection')->defaultValue('apps/monodi/data')->end()
                        ->scalarNode('username')->end()
                        ->scalarNode('password')->end()
                    ->end()
                ->end()
            ->end()
        ;       
    }
}
