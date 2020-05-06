<?php

namespace App\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PasswordUpdateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('oldPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'Taper votre ancien mot de passe'
                ]])
            ->add('newPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'Taper votre nouveau mot de passe'
                ]])
            ->add('confirmPassword', PasswordType::class, [
                'attr' => [
                    'class' => 'form-input',
                    'placeholder' => 'Confirmer votre nouveau mot de passe'
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
