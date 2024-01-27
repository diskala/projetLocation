<?php

namespace App\Form;

use App\Entity\Reservation;
use App\Entity\Car;
 
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
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

          
            
            ->add('start_date', DateType::class,[
                'label' => 'Date de début',
                'widget' => 'single_text',
                'attr' => [
                'min' => (new \DateTime('+1 day'))->format('Y-m-d'),
                ],
            ])
            ->add('end_date', DateType::class, [
                'label' => 'Date de fin',
                'widget' => 'single_text',
                
                'attr' => [
                   
               
                'min' => (new \DateTime('+2 day'))->format('Y-m-d'),
                ],

                'constraints' => [

                    
                
                    new Callback([$this, 'validateDateFin']),
                ],

                
            ])

            ->add('bail', CheckboxType::class,[
                'label' => 'Caution',
                //  'required' => false,
            ])
            ->add('option_driver', CheckboxType::class,[
                'label' => 'Chauffeur professionnel',
                 'required' => false,
            ])
            ->add('opt_child_seat', CheckboxType::class,[
                'label' => 'Siege pour enfant',
                'required' => false,
            ])
            ->add('decoration', CheckboxType::class,[
                'label' => 'Decoration pour un mariage',
                'required' => false,
            ])
            ->add('fichierPdf', FileType::class, [
                'label' => 'Télécharger un fichier PDF',
                'data_class' => null
            ])

            // ->add('priceNormalKm', CheckboxType::class)
            ->add('priceunlimitedKm', CheckboxType::class, [
                'label' => 'Prix pour un kilometrage illimité',
                'required' => false,
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

        // Comparer les dates
        if ($dateFin <= $dateDebut) {
            $message = 'La date de fin doit être ultérieure à la date de début!';
            $context->buildViolation($message)
                ->atPath('dateFin')
                ->addViolation();
        }
    }


 
    
}
