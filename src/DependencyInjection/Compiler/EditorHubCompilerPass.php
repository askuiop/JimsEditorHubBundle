<?php
/**
 * Created by PhpStorm.
 * User: jims
 * Date: 19-4-25
 * Time: 上午11:35
 */

namespace Jims\EditorHubBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class EditorHubCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        //dump($container);
        //dump($container->getExtensionConfig('twig'));
        //$twigDef = $container->getDefinition('twig');

        //$args = $twigDef->getArgument(1);
        //array_push($args['form_themes'], '@JimsEditorHub/Form/ueditor_and_umeditor_type.html.twig');
        //$twigDef->replaceArgument(1, $args);

        //dump($container->getDefinition('twig'));

        //$configuration = new Configuration();

        //dump($container->findTaggedServiceIds('twig'))
    }


}