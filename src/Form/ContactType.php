<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Votre nom '
                ]])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Votre prenom '
                ]])
            ->add('email', TextType::class, [
                'attr' => [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Votre email '
                ]])
            ->add('telephone', TextType::class, [
                'attr' => [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Votre numéro de telephone '
                ]])
            ->add('sujet', TextType::class, [
                'attr' => [
                    'label' => false,
                    'class' => 'form-control',
                    'placeholder' => 'Sujet de votre message '
                ]])
            ->add('message', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Votre numéro de telephone '
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
