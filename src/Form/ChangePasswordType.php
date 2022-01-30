<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true,
                'label' => 'Mon adresse email',
            ])

            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon prénom',
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Mon nom de famille',
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'Mon mot de passe actuel',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Veuillez saisir votre mot de passe actuel',
                ],
            ])
            // je demande à mon builder de rajouter l'input password + confirmation
            ->add('new_password', RepeatedType::class, [
                // je demande à mon builder de rajouter l'input password
                'type' => PasswordType::class,
                'mapped' => false,
                // je demande à mon builder de rajouter l'input de confirmation
                'invalid_message' => 'Les mots de passe ne correspondent pas',

                // je prépare un message en cas d'invalidité
                'label' => 'Mot de passe',
                'required' => true,
                'first_options' => [
                    'label' => 'Nouveau Mot de passe',
                    'attr' => [
                        'placeholder' => 'Votre nouveau mot de passe',
                    ]
                ],
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
                'second_options' => [
                    'label' => 'Confirmation du nouveau mot de passe',
                    'attr' => [
                        'placeholder' => 'Confirmez votre nouveau mot de passe',
                    ]
                ],
                // je prépare un label pour le second input
            ])
            
            ->add('submit', SubmitType::class, [
                'label' => 'Modifier mon mot de passe',
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
