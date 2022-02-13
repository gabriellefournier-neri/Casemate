<?php

namespace App\Form;

use App\Classe\Search;
use App\Entity\Styles;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class SearchType extends AbstractType
{

    // function pour générer le formulaire
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('string', TextType::class, [
                'label' => false,
                'required' => false,
                'attr' => [
                    'placeholder' => 'Saisissez un nom d\'artiste ou d\'album',
                    'class' => 'form-control-sm',
                ],
                
            ])
            ->add('categorie', EntityType::class, [
                'label' => false,
                'required' => false,
                'class' => Styles::class,
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Filtrer',
                'attr' => [
                    'class' => ' btn-search'
                ]
            ]);
    }

    //function pour configurer le formulaire
    public function configureOptions(OptionsResolver $resolver)
    //function configure qui utilise OptionResolver qu'on stock dans $resolver
    {
        $resolver->setDefaults([
            //je défini les valeurs par défaut
            'data_class' => Search::class,
            //je veux utiliser Search comme class de données
            'method' => 'GET',
            //j'utilise la méthode GET 
            'csrf_protection' => false,
        ]);
    }


    // function pour ne pas prefixer les champs avec le nom de la classe 
    public function getBlockPrefix()
    {
        return '';
    }
}
