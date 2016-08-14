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
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class UeditorType extends AbstractType
{
  private $major_version;

  public function __construct(Kernel $kernel)
  {
    $this->major_version = $kernel::MAJOR_VERSION;

  }
  public function configureOptions(OptionsResolver $resolver)
  {
    $resolver->setDefined('js_script');
    $resolver->setRequired('js_script');
    $resolver->setAllowedTypes('js_script', 'string');
    
    $resolver->setDefaults(array(
        'js_script' => '',
    ));

  }


  public function buildView(FormView $view, FormInterface $form, array $options)
  {
    //$view->offsetSet('jsx', $options['jsx']);
    //$view->vars->set('jsx', $options['jsx']);
    //$view->set('jsx', $options['jsx']);
    $view->vars['js_script'] = $options['js_script'];

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