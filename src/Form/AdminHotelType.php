<?php

namespace App\Form;

use App\Entity\Hotel;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminHotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('ville')
            ->add('coverImage')
            ->add('site', EntityType::class, [
                'class' => \App\Entity\SiteTouristique::class,
                'choice_label' => function ($site){
                    return $site->getTitre();
                },
                'placeholder' => 'Choix du site'

            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hotel::class,
        ]);
    }
}
