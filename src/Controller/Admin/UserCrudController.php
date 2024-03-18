<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ArrayField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            // ...
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->add(Crud::PAGE_EDIT, Action::SAVE_AND_ADD_ANOTHER)
        ;
    } 
    public function configureFields(string $pageName): iterable
{
    yield TextField::new('firstname');
    yield TextField::new('lastname');
    yield EmailField::new('email');
    yield TextField::new('address');
    yield TextField::new('phone');
    yield ArrayField::new('roles'); // Ajoutez cette ligne pour la colonne Role

    // Vous pouvez également ajouter d'autres champs si nécessaire

    // Exemple d'ajout d'un champ de date
    // yield DateField::new('createdAt');

    // Exemple d'ajout d'un champ de relation ManyToMany
    // yield AssociationField::new('groups');

    // Notez que vous devez toujours retourner un iterable à la fin de la méthode
}
}
