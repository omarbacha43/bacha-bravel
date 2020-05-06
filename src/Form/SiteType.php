<?php

namespace App\Form;

use App\Entity\SiteTouristique;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class SiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'Le titre du site touristique'
                ]])
            ->add('introduction', TextType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'Un petite introduction du site'
                ]])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'une description detailler du site '
                ]])
            ->add('photo', UrlType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'Url de la photo de couverture '
                ]])
            ->add('destination', EntityType::class, [
                'class' => \App\Entity\Destination::class,
                'choice_label' => function ($destination){
                    return $destination->getDestination();
                },
                'placeholder' => 'Choix destination'

            ])
            ->add('ancienPrix', NumberType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'ancien prix (facultatif)'
                ]])
            ->add('prix', NumberType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'le prix'
                ]])
            ->add('favoris', ChoiceType::class, [
                'choices'  => [
                    'No' => false,
                    'Yes' => true,
                ]]);

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SiteTouristique::class,
        ]);
    }
}
