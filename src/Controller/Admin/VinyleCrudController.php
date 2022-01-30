<?php

namespace App\Controller\Admin;

use App\Entity\Vinyle;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class VinyleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Vinyle::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            SlugField::new('slug')->setTargetFieldName('name'),
            TextField::new('name')
                ->setHelp('Le nom de l\'album'),
            TextField::new('artiste'),
            ImageField::new('illustration')
                ->setBasePath('uploads/covers')
                ->setUploadDir('public/uploads/covers')
                ->setFormType(FileUploadType::class)
                ->setUploadedFileNamePattern('[randomhash].[extension]'),
            TextareaField::new('description'),
            TextField::new('extract')
                ->setRequired(false)
                ->setHelp('Lien vers l\'extrait SoundCloud, Youtube ou Spotify de l\'album'),
            MoneyField::new('price')->setCurrency('EUR'),
            AssociationField::new('Style'),
        ];
    }
}
