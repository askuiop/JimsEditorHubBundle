<?php

namespace Jims\EditorHubBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UmeditorType extends AbstractType
{
    private $major_version;

    public function __construct(Kernel $kernel)
    {
        $this->major_version = $kernel::MAJOR_VERSION;

    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

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
        return 'umeditor';
    }
}
