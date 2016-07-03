<?php

namespace Jims\EditorHubBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

/**
 * This is the class that validates and merges configuration from your app/config files.
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/configuration.html}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('jims_editor_hub');
        //$rootNode = $treeBuilder->root('ueditor');

        $rootNode
            ->children()
                ->arrayNode('ueditor')
                ->children()
                    ->scalarNode('config_file')
                        ->defaultValue("%kernel.root_dir%/../src/Jims/EditorHubBundle/Resources/config/config.json")
                        ->validate()
                            ->ifTrue(function ($v) { return empty($v); })
                            ->then(function ($v) {
                                return "%kernel.root_dir%/../src/Jims/EditorHubBundle/Resources/config/config.json";
                            })
                        ->end()
                    ->end()
                ->end()
            ->end();

        $rootNode
            ->children()
                ->arrayNode('umeditor')
                  ->fixXmlConfig('allow_file')
                    ->children()
                        ->scalarNode('save_path')
                            ->defaultValue("upload/umeditor/")
                                ->validate()
                                    ->ifTrue(function ($v) { return empty($v); })
                                    ->then(function ($v) {
                                        return "upload/umeditor/";
                                    })
                                ->end()
                        ->end()
                        ->integerNode('max_size')->end()

                        ->arrayNode('allow_files')
                            ->addDefaultChildrenIfNoneSet()
                                ->prototype('scalar')->end()
                        ->end()
                    ->end()
             ->end();

        $rootNode
          ->fixXmlConfig('form_theme')
            ->children()
                ->arrayNode('form_themes')
                    ->addDefaultChildrenIfNoneSet()
                    ->prototype('scalar')->defaultValue('form_div_layout.html.twig')->end()
                ->end()
            ->end();


     //  ->fixXmlConfig('form_theme')
     //->children()
     //->arrayNode('form_themes')
     //->addDefaultChildrenIfNoneSet()
     //->prototype('scalar')->defaultValue('form_div_layout.html.twig')->end()

     //->end()
     //->end();




        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        return $treeBuilder;
    }
}
