<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('firstname', TextType::class,[
            "label"=>false,
            'constraints' => [
                new Length(['min' => 3]),
                new Regex([
                    'pattern' => '/^[a-zA-Z0-9\s]*$/',
                    'message' => 'Le Nom ne doit pas contenir de caractères spéciaux.'
                ])
            ]
        ])
        ->add('lastname', TextType::class,[
            "label"=>false,
            'constraints' => [
                new Length(['min' => 3]),
                new Regex([
                    'pattern' => '/^[a-zA-Z0-9\s]*$/',
                    'message' => 'Le prénom ne doit pas contenir de caractères spéciaux.'
                ])
            ]
        ])
        ->add('email', EmailType::class,[
            "label"=>false,
        ])
       
        ->add('plainPassword', PasswordType::class, [
           
            // instead of being set onto the object directly,
            // this is read and encoded in the controller
            "label"=>false,
            'mapped' => false,
           
            'attr' => ['autocomplete' => 'new-password'],
            'constraints' => [
                new NotBlank([
                    'message' => 'ENTRER VOTRE MOT DE PASSE',
                ]),
                new Regex('/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/', "Il faut 8 caractères une lettre en majuscule, au moin un chiffre et un caractère special"
                )],
        ])

        ->add('address', TextType::class,[
            "label"=>false,
        ])
        ->add('phone', TextType::class,[
            "label"=>false,
        ])

        ->add('agreeTerms', CheckboxType::class, [
            'mapped' => false,
            'constraints' => [
                new IsTrue([
                    'message' => 'You should agree to our terms.',
                ]),
            ],
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
