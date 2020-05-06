<?php

namespace App\Form;

use App\Entity\Destination;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DestinationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('photo', UrlType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'Url de la photo de couverture '
                ]])
            ->add('destination', TextType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'la destination'
                ]])
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
            'data_class' => Destination::class,
        ]);
    }
}
