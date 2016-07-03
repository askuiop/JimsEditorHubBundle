<?php
/**
 * Created by PhpStorm.
 * User: jimspete
 * Date: 2015/12/29
 * Time: 11:08
 */

namespace Jims\EditorHubBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class UeditorType extends AbstractType
{
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(

    ));
  }

  public function getParent()
  {
    return TextType::class;
  }

  public function getName()
  {
    return 'ueditor';
  }
}