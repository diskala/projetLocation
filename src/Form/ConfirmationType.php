<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ConfirmationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                "label" => false,
            ])
            ->add('lastname', TextType::class, [
                "label" => false,
            ])
            ->add('email', EmailType::class, [
                "label" => false,
            ])

            // Ajoutez le champ textarea
            ->add('message', TextareaType::class, [
                'label' => 'Votre message', // Label du champ
                'required' => false, // Optionnel : indique si le champ est requis ou non
                // Autres options du champ textarea peuvent être ajoutées ici
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configurez vos options de formulaire ici
        ]);
    }
}