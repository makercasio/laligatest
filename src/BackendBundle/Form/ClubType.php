<?php

namespace BackendBundle\Form;

use BackendBundle\Entity\Club;
use BackendBundle\Services\Liga\RepositoryServices\JugadorRepositoryService;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class ClubType extends AbstractType
{
    private $em;

    /**
     * ClubType constructor.
     * @param JugadorRepositoryService $jugadorRepository
     */
    public function __construct(JugadorRepositoryService $jugadorRepository)
    {
        $this->em = $jugadorRepository;

    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'nombre',
                TextType::class,
                array(
                    'required' => true,
                    'attr' => array(
                        'maxlength' => 40,
                        'placeholder' => 'Nombre'
                    )
                )
            )
            ->add('telefono',
                TextType::class,
                array('required' => false,
                    'attr' => array('maxlength' => 40,
                        'placeholder' => 'Teléfono'
                    )
                )
            )
            ->add('jugadores',
                EntityType::class,
                array(
                    'label' => 'Jugadores',
                    'required' => false,
                    'class' => 'BackendBundle\Entity\Jugador',
                    'expanded' => false,
                    'multiple' => true,
                    'query_builder' => function (EntityRepository $entityRepository) {
                        return $entityRepository->createQueryBuilder('j')
                            ->orderBy('j.id', 'desc');
                    },
                ));

            //$builder->get('jugadores')->addModelTransformer(new JugadoresToChoicesTransformer($this->em));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => Club::class,
        ));
    }

    public function getName()
    {
        return 'backendbundle_telefonotype';
    }
}
