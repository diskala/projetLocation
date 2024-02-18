<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints as Assert;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class,[
                
                'attr'=> [
                    'placeholder' => 'NOM',
                    'autocomplete' => 'off',
                ],

                'constraints' => [
                    new Assert\Length([
                        'min' => 3,
                    
                        'minMessage' => 'Votre Nom doit faire au moins {{ limit }} caractères',
                    ]),
                    new Regex([
                        'pattern' => '/^[a-zA-Z0-9\s]*$/',
                        'message' => 'Le Nom ne doit pas contenir de caractères spéciaux.'
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'attr'=> [
                    'placeholder' => 'PRÉNOM',
                    'autocomplete' => 'off',
                ],

                'constraints' => [
                    new Assert\Length([
                        'min' => 3,
                        
                        'minMessage' => 'Votre Prénom doit faire au moins {{ limit }} caractères',
                    ]),
                    new Regex('/^[a-zA-Z0-9\s]*$/', 'Le Prénom ne doit pas contenir de caractères spéciaux.'
                    )
                     
                ]
            ])
            ->add('email', EmailType::class, [
                'attr'=> [
                    'placeholder' => 'EMAIL',
                    'autocomplete' => 'off',
                ],
            ])
            ->add('phone', TextType::class, [
                'attr'=> [
                    'placeholder' => 'TÉLÉPHONE',
                    'autocomplete' => 'off',
                ],
            ])
            // ->add('achat')
            // ->add('location')
            // ->add('depotVente')
            // ->add('seminaire')
            ->add('objet', ChoiceType::class, [
               
                'choices' => [
                    'Objet' => '',
                    'Location' => 'location',
                    'Achat' => 'achat',
                    'Dépot,Vente' => 'depot_vente',
                    'Séminaire Entreprise' => 'seminaire',
                    
                ],
                'attr'=> [
                    'placeholder' => 'MESSAGE',
                    'autocomplete' => 'off',
                ],


            ])
            // ->add('dateContact')
            ->add('message', TextareaType::class,[
                // 'attr' => [
                //     'placeholder' => 'Message'
                // ]
                'attr'=> [
                    'autocomplete' => 'off',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
