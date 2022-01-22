<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\Inflector\Rules\Pattern;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre prénom',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre prénom doit faire au moins {{ limit }} caractères',
                        'max' => 50,
                        'maxMessage' => 'Votre prénom ne peut pas faire plus de {{ limit }} caractères',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Merci de saisir un prénom',
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre nom',
                    ]),
                    new Length([
                        'min' => 2,
                        'minMessage' => 'Votre nom doit faire au moins {{ limit }} caractères',
                        'max' => 50,
                        'maxMessage' => 'Votre nom ne peut pas faire plus de {{ limit }} caractères',
                    ]),
                ],
                'attr' => [
                    'placeholder' => 'Merci de saisir un nom',
                ]
            ])
            // je demande à mon builder de rajouter l'input email
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'attr' => [
                    'placeholder' => 'Votre adresse@mail.fr',
                ]
            ]) 
            // je demande à mon builder de rajouter l'input password + confirmation
            ->add('password', RepeatedType::class, [
                // je demande à mon builder de rajouter l'input password
                'type' => PasswordType::class,
                // je demande à mon builder de rajouter l'input de confirmation
                'invalid_message' => 'Les mots de passe ne correspondent pas',

                // je prépare un message en cas d'invalidité
                'label' => 'Mot de passe',
                'required' => true,
                'first_options' => ['label' => 'Mot de passe',],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez renseigner votre mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit faire au moins {{ limit }} caractères',
                        'max' => 50,
                        'maxMessage' => 'Votre mot de passe ne peut pas faire plus de {{ limit }} caractères',
                    ]),
                    
                ],
                // je prépare un label pour le premier input
                'second_options' => ['label' => 'Confirmation du mot de passe'],
                // je prépare un label pour le second input
            ]) 

            // on veut un mot de passe de 8 caractères minimum avec au moins une majuscule, une minuscule et un chiffre et un caractère spécial

            








            ->add('submit', SubmitType::class, [
                'label' => 'Créer mon compte',
                'attr' => [
                    'class' => 'btn btn-primary',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
