<?php

namespace App\Form;

use App\Entity\Hotel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class HotelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => "Le nom de l'hotel"
                ]])
            ->add('ville', TextType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'Le nom de la ville'
                ]])
            ->add('coverImage',UrlType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'Url de la photo de couverture'
                ]])
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
