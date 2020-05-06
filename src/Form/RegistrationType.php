<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegistrationType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'label' => false,
                    'class' => 'form-input',
                    'placeholder' => 'Votre nom '
            ]])
            ->add('prenom', TextType::class, [
                'attr' => [
                    'label' => false,
                    'class' => 'form-input',
                    'placeholder' => 'Votre prenom '
                ]])
            ->add('email', TextType::class, [
                'attr' => [
                    'label' => false,
                    'class' => 'form-input',
                    'placeholder' => 'Votre email '
                ]])
            ->add('telephone', TextType::class, [
                'attr' => [
                    'label' => false,
                    'class' => 'form-input',
                    'placeholder' => 'Votre numéro de telephone '
                ]])
            ->add('profession', TextType::class, [
                'attr' => [
                    'label' => false,
                    'class' => 'form-input',
                    'placeholder' => 'Votre profession'
                ]])
            ->add('photo', UrlType::class, [
                'attr' => [
                    'label' => false,
                    'class' => 'form-input',
                    'placeholder' => 'Url de votre photo de profile '
                ]])
            ->add('introduction', TextType::class, [
                'attr' => [
                    'label' => false,
                    'class' => 'form-input',
                    'placeholder' => 'Parlez-nous de vous en quelque mot'
                ]])
            ->add('password', PasswordType::class, [
                'attr' => [
                    'label' => false,
                    'class' => 'form-input',
                    'placeholder' => 'Taper votre nouveau mot de passe'
                ]])
            ->add('passwordConfirm', PasswordType::class, [
                'attr' => [
                    'label' => false,
                    'class' => 'form-input',
                    'placeholder' => 'confirmez votre mot de passe'
                ]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
