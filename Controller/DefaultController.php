<?php

namespace Jims\EditorHubBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('JimsEditorHubBundle:Default:index.html.twig');
    }
}
