<?php

namespace Jims\EditorHubBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration.
 *
 * @link http://symfony.com/doc/current/cookbook/bundles/extension.html
 */
class JimsEditorHubExtension extends Extension implements PrependExtensionInterface
{
    /**
     * {@inheritdoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        if (!empty($config['ueditor'])) {
            $container->setParameter("jims_ueditor", $config['ueditor']);
        }

        if (!empty($config['umeditor'])) {
            $container->setParameter("jims_umeditor", $config['umeditor']);
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    public function prepend(ContainerBuilder $container)
    {
        if (!$container->hasExtension('twig')) {
            return ;
        }
        //$args = $container->getExtensionConfig('twig');

        $formThemePath  = '@JimsEditorHub/Form/ueditor_and_umeditor_type.html.twig';

        $container->prependExtensionConfig('twig', [
            'form_themes' => [ $formThemePath ]
        ]);

    }


}
