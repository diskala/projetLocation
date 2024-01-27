<?php

namespace App\Controller\Admin;

use App\Entity\Car;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Invoice;
use App\Entity\Reservation;
use App\Repository\ActionRepository;
use App\Repository\ActionStatusRepository;
use App\Repository\CarRepository;
use Symfony\Component\Mime\Email;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
 
 
 
 



class DashboardController extends AbstractDashboardController
{

    protected $ReservationRepository;
    protected $CarRepository;
    protected $actionStatusRepository;
    protected $entityManager;

    public function __construct(
        ReservationRepository $Reservation, CarRepository $CarRepository, ActionStatusRepository $actionStatusRepository, EntityManagerInterface $entityManager
    ) {
        $this->ReservationRepository = $Reservation;
        $this->CarRepository = $CarRepository;
        $this->actionStatusRepository = $actionStatusRepository;
        $this->entityManager = $entityManager;
        
        // dd($Reservation->ReservationAccepted()->get);
        
    }
      // pour pouvoir ajouter du style
    public function configureAssets(): Assets
    {
        return parent::configureAssets()
        ->addCssFile('styles/dashboard.css');
        // ->addHtmlContentToHead('<link rel="dns-prefetch" href="https://assets.example.com">');
    }


    #[Route('/admin', name: 'admin_index')]
    public function index(): Response
    {
        $acts = $this->actionStatusRepository->actiones(); // recupérer la table actionStatus
        $actsObj= $acts[0]; // récupérer le 1er index
        $voitureLouee = $actsObj->isRentedCar();  // recupérer la valeur actuel de rentedCar si la voiture est sortie ou pas
        $voitureRestituee = $actsObj->isReturnedCar();  // recupérer la valeur actuel returnedCar si la voiture restituée ou pas
         // nombre de reservation 
        $nombreDeReservations = $this->ReservationRepository->count([]);

        // calcule nombre des reservations non confirmer
        $allReservation = $this->ReservationRepository->ReservationNonConfirmed();
        $reservationNonConfirme = [];
         foreach( $allReservation as $res){
            $reservationNonConfirme[$res->getId()] = $res->isConfirmed();
         }
        
         $NonConfirmeds = count($reservationNonConfirme);
         
        
        // $nombreCars=$this->CarRepository->count([]); // nombere de voitures total 
       $allCars= $this->CarRepository->findcar();
      // Créer un tableau pour stocker les stocks de chaque voiture
    $quantityVoitures = [];
    $stockVoitures = [];
    
    // Parcourir chaque voiture pour obtenir son stock
    foreach ($allCars as $voiture) {
        $quantityVoitures[$voiture->getId()] = $voiture->getQuantity(); // charger la quantity de chaque voiture dans un tableau
        $stockVoitures[$voiture->getId()] = $voiture->getStock();   // charger le stock de chaque voiture dans un tableau
    }

    $nombreVoiture = array_sum($quantityVoitures );// nombere de voitures total 
    $nombresAuStock = array_sum($stockVoitures ); // nombre de voitures disponible au stock

    
    $nombreVoitureSortie = $nombreVoiture - $nombresAuStock; // calculer le nombre de voiture actuellement louées
      
        // // nombre de voiture disponible

        // $nombreDeVoituresDisponibles=$this->CarRepository->NombrecarsDisponible();
        
     
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(CarCrudControllerController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
         return $this->render('admin/dashboard.html.twig',[
            'reserved'=>$this->ReservationRepository->ReservationAccepted(), // reservation status accepeted
            'actionStatus'=>$this->actionStatusRepository->actiones(), // recupérer toute la table actionStatus
            'nombreReaservation'=>$NonConfirmeds, // nombre de reservations non confirmé
            'nombreTotalVoitures'=>$nombreVoiture, // nombre de voiture total 
            'nombresAuStock'=>$nombresAuStock, // nombre de voiture disponible au stock
            'nombreVoitureSortie'=> $nombreVoitureSortie,
            'voitureLouee'=> $voitureLouee,
            'voitureRestituee'=> $voitureRestituee
         ]);
    }

    // toute les reservation confirmés
    #[Route('admin/selection', name: 'app_selection')]
    public function selection(ReservationRepository $Reservation, CarRepository $CarRepository, ActionStatusRepository $actionStatusRepository, EntityManagerInterface $entityManager){

        $allCars= $this->CarRepository->findcar();
        // Créer un tableau pour stocker les stocks de chaque voiture
      $quantityVoitures = [];
      $stockVoitures = [];
      
      // Parcourir chaque voiture pour obtenir son stock
      foreach ($allCars as $voiture) {
          $quantityVoitures[$voiture->getId()] = $voiture->getQuantity(); // charger la quantity de chaque voiture dans un tableau
          $stockVoitures[$voiture->getId()] = $voiture->getStock();   // charger le stock de chaque voiture dans un tableau
      }
  
      $nombreVoiture = array_sum($quantityVoitures );// nombere de voitures total 
      $nombresAuStock = array_sum($stockVoitures ); // nombre de voitures disponible au stock
  
      
      $nombreVoitureSortie = $nombreVoiture - $nombresAuStock; // calculer le nombre de voiture actuellement louées
        return $this->render('admin/resConfirmed.html.twig',[
            'reserved'=>$this->ReservationRepository->ReservationAccepted(), // reservation status accepeted
            'nombresAuStock'=>$nombresAuStock, // nombre de voiture disponible au stock
            'nombreVoitureSortie'=> $nombreVoitureSortie,
             
         ]);
    }


    #[Route('admin/confirme/{id}', name: 'app_confirme')]
    public function sendConfirmationEmail($id, MailerInterface $mailer, ReservationRepository $res, ActionStatusRepository $actionStatusRepository, EntityManagerInterface $entityManager)
    {
        // Récupérer l'élément réservé par son identifiant
        $reservation = $res->find($id);
        $actions = $actionStatusRepository->actionReservation($id);
        $actionObj=$actions[0];
        // Vérifier si la réservation existe
        if (!$reservation) {
            throw $this->createNotFoundException('La réservation avec l\'ID ' . $id . ' n\'existe pas.');
        }

        $reservation->setConfirmed(true);
        $actionObj->setConfirmed(true);
        $entityManager->flush();
        // Autres logiques liées à l'envoi de l'e-mail...
    
        // // Envoyer l'e-mail de confirmation
        // $email = (new Email())
        //     ->from('votre@email.com')
        //     ->to($reservation->getUsers()->getEmail())
        //     ->subject('Confirmation de réservation')
        //     ->html("<p>Votre réservation a été confirmée avec succès. {$reservation->getUsers()->getFirstName()} </p>");
    
        // $mailer->send($email);
    
        // Autres logiques après l'envoi de l'e-mail...
    
        return $this->redirectToRoute('admin_index');
         
       
        
    }



    #[Route('/dashboard/fichierPdf/{id}', name: 'app_FichierPdf')]
    public function downloadPDF($id)
    {
        // Récupérer la réservation depuis la base de données
        $reservation = $this->ReservationRepository->find($id);
        
        // Vérifier si la réservation existe
        if (!$reservation) {
            throw $this->createNotFoundException('Réservation non trouvée');
        }
    
        // Récupérer le nom du fichier PDF depuis la réservation (adaptez cette partie selon votre modèle de données)
        $pdfFileName = $reservation->getFichierPdf(); // Assurez-vous que cette méthode retourne le nom du fichier
    
        // Vérifier si le nom du fichier PDF est valide
        if (!$pdfFileName) {
            throw new \Exception('Le nom du fichier PDF est invalide');
        }
    
        // Définir le chemin complet du fichier PDF dans le sous-dossier 'fichierPdf' du répertoire public
        $pdfPath = $this->getParameter('kernel.project_dir') . '/public/fichier_Pdf/' . $pdfFileName;
    
        // Vérifier si le fichier existe
        if (!file_exists($pdfPath)) {
            throw new \Exception('Le fichier PDF n\'existe pas');
        }
    
        // Lire le contenu du fichier PDF
        $pdfContent = file_get_contents($pdfPath);
    
        // Retourner une réponse HTTP avec le contenu du PDF
        return new Response($pdfContent, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="reservation.pdf"',
        ]);
    }


 #[route("dashboard/updateStock/{id}", name: 'app_updateStock')]
 public function Update($id, EntityManagerInterface $entityManager, CarRepository $carRepository, ReservationRepository $reserved, ActionStatusRepository $actionStatusRepository){
       $tRes= $reserved->userCarReservation($id);
       $res = $reserved->find($id);
       $actionStatus = $actionStatusRepository->actionReservation($id);
       $actionStatusObj = $actionStatus[0]; // Accéder à l'objet ActionStatus dans le tableau
      $rCar= $carRepository->find($id);
    
      if ($res && $actionStatus) {
        if ($res->isConfirmed()) {
            if ($res->getCar()->getStock() > 0) {
                $newStock = $res->getCar()->getStock() - 1;
                
                $res->getCar()->setStock($newStock);
              
                $actionStatusObj->setRentedCar(true);
                $actionStatusObj->setDateRental(new \DateTime());
                $entityManager->flush();
                return $this->redirectToRoute('app_selection');
            } else {
                $res->getCar()->setAvailable(false);
                $entityManager->flush();
                $this->addFlash('alert', 'La voiture n\'est plus disponible en stock.');
                return $this->redirectToRoute('app_selection');
            }
        } else {
            $this->addFlash('alert', 'La réservation n\'est pas confirmée.');
            return $this->redirectToRoute('app_selection');
        }
    } else {
        $this->addFlash('alert', 'La réservation ou le statut d\'action n\'a pas été trouvé.');
        return $this->redirectToRoute('app_selection');
    }


 
 }



 #[route("dashboard/RestitueStock/{id}", name: 'app_restitueStock')]
 public function Restitue($id, EntityManagerInterface $entityManager, CarRepository $carRepository, ReservationRepository $reserved, ActionStatusRepository $actionStatusRepository){
       $tRes= $reserved->userCarReservation($id);
       $res = $reserved->find($id);
       $actionStatus = $actionStatusRepository->actionReservation($id);
       $actionStatusObj = $actionStatus[0]; // Accéder à l'objet ActionStatus dans le tableau
      $rCar= $carRepository->find($id);
    
      if ($res && $actionStatus) {
        if ($res->isConfirmed() && $actionStatusObj->isConfirmed()) {
            
                $restitueStock = $res->getCar()->getStock() + 1;
                $res->getCar()->setStock($restitueStock);
                // $actionStatusObj->setRentedCar(false);
                $actionStatusObj->setReturnedCar(true);
                $actionStatusObj->setReturnDate(new \DateTime());
                $entityManager->flush();
                return $this->redirectToRoute('app_selection');
            
        } else {
            $this->addFlash('alert', 'La réservation n\'est pas confirmée.');
            return $this->redirectToRoute('app_selection');
        }
    } else {
        $this->addFlash('alert', 'La réservation ou le statut d\'action n\'a pas été trouvé.');
        return $this->redirectToRoute('app_selection');
    }


 
 }


    public function configureDashboard(): Dashboard
    {
        
        return Dashboard::new()
            // ->setTitle('DisCars');
            
          -> setTitle('<img src="/icones_drapeaux/logo2.png">');
          

        
            
    }

     

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Car', 'fas fa-car', Car::class);
        yield MenuItem::linkToCrud('Reservation', 'fas fa-cart-shopping', Reservation::class);
        yield MenuItem::linkToCrud('Invoice', 'fas fa-file-invoice', Invoice::class);
        yield MenuItem::linkToCrud('Image', 'fas fa-image', Image::class);
        yield MenuItem::linkToCrud('User', 'fas fa-user', User::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }

    
}
