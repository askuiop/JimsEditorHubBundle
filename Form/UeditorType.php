<?php
/**
 * Created by PhpStorm.
 * User: jimspete
 * Date: 2015/12/29
 * Time: 11:08
 */

namespace Jims\EditorHubBundle\Form;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UeditorType extends AbstractType
{
  private $major_version;

  public function __construct(Kernel $kernel)
  {
    $this->major_version = $kernel::MAJOR_VERSION;

  }
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefaults(array(

    ));
  }

  public function getParent()
  {
    if ($this->major_version==3) {
      return TextareaType::class;
    }
    return 'textarea';
  }

  public function getName()
  {
    return 'ueditor';
  }
}