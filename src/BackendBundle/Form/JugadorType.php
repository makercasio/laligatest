<?php

namespace BackendBundle\Form;

use BackendBundle\Entity\Jugador;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class JugadorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nombre', TextType::class, array('required' => true, 'attr' => array('maxlength' => 40, 'placeholder' => 'Nombre')));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => Jugador::class,
        ));
    }

    public function getName()
    {
        return 'backendbundle_jugadortype';
    }
}
