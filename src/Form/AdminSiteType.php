<?php

namespace App\Form;

use App\Entity\SiteTouristique;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminSiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('photo')
            ->add('introduction')
            ->add('destination', EntityType::class, [
                'class' => \App\Entity\Destination::class,
                'choice_label' => function ($destination){
                    return $destination->getDestination();
                },
                'placeholder' => 'Choix destination'

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SiteTouristique::class,
        ]);
    }
}
