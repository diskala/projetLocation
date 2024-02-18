<?php

namespace App\Form;

use App\Entity\Car;
use App\Entity\Reservation;
 
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

class ReservationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        
        // ->add('marque', EntityType::class, [
        //     'class' => 'App\Entity\Car',
        //     'choice_label' => 'brand', // Remplacez 'marque' par le nom de l'attribut que vous souhaitez afficher
        //     'disabled' => true, // Le champ est désactivé
        // ])
        // ->add('modele', EntityType::class, [
        //     'class' => 'App\Entity\Car',
        //     'choice_label' => 'model', // Remplacez 'marque' par le nom de l'attribut que vous souhaitez afficher
        //     'disabled' => true, // Le champ est désactivé
        // ])

          
            
        ->add('start_date', DateType::class, [
            'label' => 'Date de début',
            'widget' => 'single_text',
            'required' => false,
            'data_class' => null,
            'attr' => [
                'min' => (new \DateTime('+1 day'))->format('Y-m-d'),
                'autocomplete' => 'off',
            ],
            'constraints' => [
                new Callback([$this, 'validateDateFin']),
                // new NotBlank([
                //     'message' => 'Veuillez saisir une date de début.',
                //     'normalizer' => function ($value) {
                //         return !empty($value);
                //     },
                // ]),
            ],
        ])
        ->add('end_date', DateType::class, [
            'label' => 'Date de fin',
            'widget' => 'single_text',
            'required' => false,
            'data_class' => null,
            // 'empty_data' => '',
            'attr' => [
                'min' => (new \DateTime('+2 day'))->format('Y-m-d'),
                'autocomplete' => 'off',
            ],
            'constraints' => [

                new Callback([$this, 'validateDateFin']),
                // new GreaterThan([
                //     'value' => '+2 days',
                //     'message' => 'La date de fin doit être au moins {{ compared_value }}.',
                // ]),
                // new LessThanOrEqual([
                //     'value' => '+3 days',
                //     'message' => 'La date de fin doit être au plus {{ compared_value }}.',
                // ]),

                // new NotBlank([
                //     'message' => 'Veuillez saisir une date de début.',
                //     'normalizer' => function ($value) {
                //         return !empty($value);
                //     },
                // ]),
            ],
        ])

             // new Callback([$this, 'validateDateFin']),
            ->add('option_driver', CheckboxType::class,[
                'label' => 'Chauffeur professionnel',
                 'required' => false,
                 
                
                 'attr' => [
                    'autocomplete' => 'off', // Ajoutez cet attribut
                ],
            ])
            ->add('opt_child_seat', CheckboxType::class,[
                'label' => 'Siege pour enfant',
                'required' => false,
                
                // 'empty_data' => '',
                'attr' => [
                    'autocomplete' => 'off', // Ajoutez cet attribut
                ],
            ])
            ->add('decoration', CheckboxType::class,[
                'label' => 'Decoration pour un mariage',
                'required' => false,
                // 'empty_data' => '',
                'attr' => [
                    'autocomplete' => 'off', // Ajoutez cet attribut
                ],
            ])
            ->add('fichierPdf', FileType::class, [
                'label' => 'Télécharger un fichier PDF',
                'data_class' => null,
                'required'=>false,
                // 'empty_data' => '',
                'attr' => [
                    'autocomplete' => 'off', // Ajoutez cet attribut
                ],
            ])

            // ->add('priceNormalKm', CheckboxType::class)
            ->add('priceunlimitedKm', CheckboxType::class, [
                'label' => 'Prix pour un kilometrage illimité',
                'required' => false,
                // 'empty_data' => '',
                'attr' => [
                    'autocomplete' => 'off', // Ajoutez cet attribut
                ],
            ])
            ->add('bail', CheckboxType::class, [
                'label' => 'caution',
                'required' => false,
                // 'empty_data' => '',
                'attr' => [
                    'autocomplete' => 'off', // Ajoutez cet attribut
                ],
            ])
            ->add('envoyer', SubmitType::class, [
                'label' => 'Payer la caution et reserver',
                
            ])
           
            
            
           ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reservation::class,
        ]);
    }


     public function validateDateFin($dateFin, ExecutionContextInterface $context)
    {
        // Récupérer la valeur de dateDebut depuis le formulaire
        $dateDebut = $context->getRoot()->get('start_date')->getData();
        $dateFin = $context->getRoot()->get('end_date')->getData();
        $startDatePlusTwoDays = (clone $dateDebut)->modify('+1 days');
        
         
        // Comparer les dates
        if ($dateFin <= $dateDebut) {
            $message = 'La date de fin doit être ultérieure à la date de début!';
            $context->buildViolation($message)
                ->atPath('dateFin')
                ->addViolation();
        }
        elseif ($dateFin > $startDatePlusTwoDays ) {
            $message = 'La location ne doit pas dépasser 24 heures! redéfinir la date de fin';
            $context->buildViolation($message)
                ->atPath('dateFin')
                ->addViolation();
        }
        
    }


 
    
}
