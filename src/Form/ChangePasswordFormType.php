<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'Nouveau mot de passe',
                    ],
                ],
                'first_options' => [
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Veuillez entrer votre Mot de passe',
                        ]),
                        new Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', "Il faut 8 caractères une lettre en majuscule, au moin un chiffre et un caractère special"
                    )
                    ],
                    'label' => 'Nouveau mot de passe',
                    'label_attr' => ['style' => 'margin-right: 1.9rem;  font-weight: bold;'], // Ajoute de l'espace à droite du label
                    'row_attr' => ['style' => 'margin-bottom: 1rem ;'], // Ajoute de l'espace en bas
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe ',
                    'label_attr' => ['style' => 'margin-right: 1rem; font-weight: bold;'], // Ajoute de l'espace à droite du label
                ],
                'invalid_message' => 'Les champs du mot de passe doivent se correspondre.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
