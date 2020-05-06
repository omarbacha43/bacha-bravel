<?php

namespace App\Form;

use App\Entity\Blog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre', TextType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'tiitre de votre evenement'
                ]])
            ->add('photo', UrlType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'Url de la photo de couverture '
                ]])
            ->add('date', DateType::class, [
                'attr' => [
                    'class' => 'form-input',
                ]])
            ->add('introduction', TextType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'petite introduction'
                ]])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'redigé une description'
                ]])
            ->add('favoris', ChoiceType::class, [
                'choices'  => [
                    'No' => false,
                    'Yes' => true,
                ]]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Blog::class,
        ]);
    }
}
