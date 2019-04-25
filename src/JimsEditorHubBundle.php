<?php

namespace Jims\EditorHubBundle;

use Jims\EditorHubBundle\DependencyInjection\Compiler\EditorHubCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class JimsEditorHubBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        $container->addCompilerPass(new EditorHubCompilerPass());
    }

}
