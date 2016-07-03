<?php

namespace Jims\EditorHubBundle\Form;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UmeditorType extends AbstractType
{
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
        return TextType::class;
    }


    public function getName()
    {
        return 'umeditor';
    }
}
