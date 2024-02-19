<?php

namespace App\Controller\Admin;

use Dompdf\Dompdf;
use App\Entity\Car;
use App\Entity\Contact;
use App\Entity\User;
use App\Entity\Image;
use App\Entity\Invoice;
use App\Entity\Reservation;
use App\Form\FacturationType;
use App\Form\ConfirmationType;
use App\Repository\CarRepository;
use Symfony\Component\Mime\Email;
use App\Form\SearchReservationType;
use App\Repository\ActionRepository;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use App\Repository\ActionStatusRepository;
use App\Repository\ContactRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use EasyCorp\Bundle\EasyAdminBundle\Provider\AdminContextProvider;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{

    protected $ReservationRepository;
    protected $CarRepository;
    protected $ActionStatusRepository;
    protected $entityManager;
    protected $AdminUrlGenerator;
    protected $AdminContextProvider;
    protected $contactRepository;

    public function __construct(
        ReservationRepository $Reservation, CarRepository $CarRepository,
         ActionStatusRepository $actionStatusRepository, EntityManagerInterface $entityManager,
          AdminUrlGenerator $adminUrlGenerator, AdminContextProvider $adminContextProvider, ContactRepository $contactRepository
         
    ) {
        $this->ReservationRepository = $Reservation;
        $this->CarRepository = $CarRepository;
        $this->ActionStatusRepository = $actionStatusRepository;
        $this->entityManager = $entityManager;
         $this->AdminUrlGenerator = $adminUrlGenerator;
        $this->AdminContextProvider = $adminContextProvider;
        $this->contactRepository = $contactRepository; 
        
        
        // dd($Reservation->ReservationAccepted()->get);
        
    }
      // pour pouvoir ajouter du style
    public function configureAssets(): Assets
    {
        return parent::configureAssets()
        ->addCssFile('styles/dashboard.css')
        ->addCssFile('styles/resConfirmed.css')
        ->addCssFile('styles/restituees.css')
        ->addCssFile('styles/cloturees.css')
        // ->addCssFile('styles/facture.css')
        // ->addHtmlContentToHead('<link rel="dns-prefetch" href="https://assets.example.com">');
        ;
    }


    #[Route('/admin', name: 'admin_index')]
    public function index(): Response
    {

     $this->redirect($this->AdminUrlGenerator->setController(CarCrudController::class)->generateUrl()); // À garder.
        $acts = $this->ActionStatusRepository->actiones(); // recupérer la table actionStatus
        $actsObj= $acts[0]; // récupérer le 1er index
        $voitureLouee = $actsObj->isRentedCar();  // recupérer la valeur actuel de rentedCar si la voiture est sortie ou pas
        $voitureRestituee = $actsObj->isReturnedCar();  // recupérer la valeur actuel returnedCar si la voiture restituée ou pas
         // nombre de reservation 
        $nombreDeReservations = $this->ReservationRepository->count([]);
 // nombre de contact
 $nombreDeContact = $this->contactRepository->count([]);
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
            'actionStatus'=>$this->ActionStatusRepository->actiones(), // recupérer toute la table actionStatus
            'nombreReservation'=>$NonConfirmeds, // nombre de reservations non confirmé
            'nombreTotalVoitures'=>$nombreVoiture, // nombre de voiture total 
            'nombresAuStock'=>$nombresAuStock, // nombre de voiture disponible au stock
            'nombreVoitureSortie'=> $nombreVoitureSortie,
            'voitureLouee'=> $voitureLouee,
            'voitureRestituee'=> $voitureRestituee,
            'nombreDeContact' =>  $nombreDeContact // nombre de contact
          
         ]);
    }

    #[Route('/admin/header', name: 'app_header')]
    public function header( ContactRepository $contactRepository)
    {
        $acts = $this->ActionStatusRepository->actiones(); // recupérer la table actionStatus
        $actsObj= $acts[0]; // récupérer le 1er index
        $voitureLouee = $actsObj->isRentedCar();  // recupérer la valeur actuel de rentedCar si la voiture est sortie ou pas
        $voitureRestituee = $actsObj->isReturnedCar();  // recupérer la valeur actuel returnedCar si la voiture restituée ou pas
        // nombre de contact
        $nombreDeContact = $contactRepository->count([]);
        
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




    return $this->render('admin/header.html.twig',[
        'reserved'=>$this->ReservationRepository->ReservationAccepted(), // reservation status accepeted
        'actionStatus'=>$this->ActionStatusRepository->actiones(), // recupérer toute la table actionStatus
        'nombreReservation'=>$NonConfirmeds, // nombre de reservations non confirmé
        'nombreTotalVoitures'=>$nombreVoiture, // nombre de voiture total 
        'nombresAuStock'=>$nombresAuStock, // nombre de voiture disponible au stock
        'nombreVoitureSortie'=> $nombreVoitureSortie,
        'voitureLouee'=> $voitureLouee,
        'voitureRestituee'=> $voitureRestituee
     ]);
    }


    // toute les reservation confirmés
    #[Route('admin/selection', name: 'app_selection')]
    public function selection(ReservationRepository $Reservation, CarRepository $CarRepository, ActionStatusRepository $actionStatusRepository, InvoiceRepository $invoice, EntityManagerInterface $entityManager){

        $allCars= $this->CarRepository->findcar();
        $resRestitues = $actionStatusRepository->CarEnLocation();
        $resConfirme = $Reservation->ReservationConfirmed();
        $oneRes = end($resConfirme);
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
            'reserved'=>$this->ReservationRepository->ReservationConfirmed(), // reservations confirmées
            'nombresAuStock'=>$nombresAuStock, // nombre de voiture disponible au stock
            'nombreVoitureSortie'=> $nombreVoitureSortie,
            'voitureRestituees'=> $resRestitues,
            'nombreTotalVoitures'=>$nombreVoiture, // nombre de voiture total 
             'endReserved'=> $oneRes
         ]);
    }

    // toute les voitures actuellement en location 
    #[Route('admin/enLocation', name: 'app_location')]
    public function location(ReservationRepository $Reservation, CarRepository $CarRepository, ActionStatusRepository $actionStatusRepository, EntityManagerInterface $entityManager){

        $allCars= $this->CarRepository->findcar();
        $resRestitues = $actionStatusRepository->CarEnLocation(); // les reservations actuellement en location
        
        
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


// établir la facture en fonction de id reservation







        return $this->render('admin/enLocation.html.twig',[
            'reserved'=>$this->ReservationRepository->ReservationConfirmed(), // reservations confirmées
            'nombresAuStock'=>$nombresAuStock, // nombre de voiture disponible au stock
            'nombreVoitureSortie'=> $nombreVoitureSortie,
            'nombreTotalVoitures' => $nombreVoiture ,
            'voitureRestituees'=> $resRestitues
             
         ]);
    }


    #[Route('admin/resCloturees', name: 'app_resClotures')]
    public function cloture(ReservationRepository $reservation, InvoiceRepository $invoice, ActionStatusRepository $actions, EntityManagerInterface $entityManager, Request $request): Response
    {

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

        $form = $this->createForm(SearchReservationType::class);
        $form->handleRequest($request);

        $reservationCloturees = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $rechercheParDateDebut = $form->get('dateLocation')->getData();
            $rechercheParDateRetour = $form->get('dateRetour')->getData();
          
            $rechercheEmail = $form->get('email')->getData();

            if (!empty($rechercheEmail)) {
                $reservationCloturees = $actions->actionClotureesEmail($rechercheEmail);
                if (empty($reservationCloturees)) {
                    $this->addFlash('alert', '<div class="flash-message">L\'adresse email n\'existe pas!');
                    return $this->redirectToRoute('app_resClotures');
                }
            } elseif (!empty($rechercheParDateDebut) && !empty($rechercheParDateRetour)) {

                $reservationCloturees = $actions->actionClotureesDateDebutEtRetour($rechercheParDateDebut,$rechercheParDateRetour);
                if (empty($reservationCloturees)) {
                    $this->addFlash('alert', '<div class="flash-message">La date de début de location ou la date de retour n\'existe pas!');
                    return $this->redirectToRoute('app_resClotures');
                   
                   
                }  
                
            } elseif (!empty($rechercheParDateDebut) && empty($rechercheParDateRetour)) {

                $reservationCloturees = $actions->actionClotureesDateDebut($rechercheParDateDebut);
                if (empty($reservationCloturees)) {
                    $this->addFlash('alert', '<div class="flash-message">La date de début de location  n\'existe pas!');
                    return $this->redirectToRoute('app_resClotures');
                   
                   
                }  
                
            } elseif (empty($rechercheParDateDebut) && !empty($rechercheParDateRetour)) {

                $reservationCloturees = $actions->actionClotureesDateRetour($rechercheParDateRetour);
                if (empty($reservationCloturees)) {
                    $this->addFlash('alert', ' <div class="flash-message">la date de retour n\'existe pas!');
                    return $this->redirectToRoute('app_resClotures');
                   
                   
                }  
                
            } 
            

            
             else {
                $reservationCloturees = $actions->ResrvationCloturees();
            }
        } else {
            $reservationCloturees = $actions->ResrvationCloturees();
        }
            
          
        return $this->render('admin/resCloturees.html.twig', [
            'reserved' => $this->ReservationRepository->ReservationConfirmed(), // reservations confirmées
            'resCloturees' => $reservationCloturees,
            'nombreTotalVoitures'=>$nombreVoiture,
            'searchReservation' => $form->createView()
            
        ]);
    }

    




    #[Route('admin/facture', name: 'app_facture')]
    public function facturation( Dompdf $dompdf, ReservationRepository $reservation, InvoiceRepository $invoice, ActionStatusRepository $actions, EntityManagerInterface $entityManager, Request $request): Response
    {

       
       // Vérifie si le formulaire a été soumis
       if ($request->isMethod('POST')) {
        // Récupère les données du formulaire
        $selectedItemId = $request->request->get('selectedItem');

        // Faites quelque chose avec l'ID récupéré, par exemple :
    if($selectedItemId){
        $actionFacture = $actions->actionReservation($selectedItemId);
        $invoiceFacture = $invoice->invoiceReservation($selectedItemId);
    } else {
        $this->addFlash('alert', '<div class="flash-message">selectionner une reservation ');
        return $this->redirectToRoute('app_resClotures');
    }
       
    }
   
//     // Logique de facturation
// Logique de facturation

 
$content = $this->renderView('admin/facture.html.twig', ['etablissementFacture' => $invoiceFacture]);

// Rendu du PDF
$dompdf->loadHtml($content);

// Rendu du PDF
$dompdf->render();
$pdfRelativePath = 'facture-pdf/' . $invoiceFacture->getNumber() . $selectedItemId . '.pdf';

$pdfFilePath = $this->getParameter('kernel.project_dir') . '/public/' . $pdfRelativePath;

file_put_contents($pdfFilePath, $dompdf->output());
$invoiceFacture->setFacturePdf($pdfRelativePath);
$entityManager->persist($invoiceFacture);

// Enregistrer les modifications en base de données
$entityManager->flush();

// Envoi du PDF en réponse
return new Response($dompdf->output(), 200, [
    'Content-Type' => 'application/pdf',
]);
  




        return $this->render('admin/facture.html.twig', [
            
            'etablissementFacture'=>$invoiceFacture
             

            
        ]);
    }


    // envois un mail de confirmation
    // #[Route('admin/mail/{id}', name: 'app_mail', methods: ['POST'])]
    // public function Mail($id, MailerInterface $mailer, Request $request, ReservationRepository $res){
      
    //   dd( $id);
    //  $reserved= $res->find($id);
        
    //    $email = (new Email())
    //         ->from('votre@email.com')
    //         ->to($reserved->getUsers()->getEmail())
    //         ->subject('Confirmation de réservation')
    //         ->html("<p>Votre réservation a été confirmée avec succès. {$reserved->getUsers()->getFirstName()} </p>");
    
    //     $mailer->send($email);
        
    //     // Autres logiques après l'envoi de l'e-mail...
    //     // return $this->redirectToRoute('admin_index'); 
    // }

    #[Route('admin/confirme/{id}', name: 'app_confirme')]
    public function sendConfirmationEmail($id, MailerInterface $mailer, ReservationRepository $res, ActionStatusRepository $actionStatusRepository, EntityManagerInterface $entityManager, InvoiceRepository $invoiceRepository)
    {
        // Récupérer l'élément réservé par son identifiant
        $reservation = $res->find($id);
        
        $actions = $actionStatusRepository->actionReservation($id);
        // $actionObj=$actions[0];
        // Vérifier si la réservation existe
        if (!$reservation) {
            throw $this->createNotFoundException('La réservation avec l\'ID ' . $id . ' n\'existe pas.');
        }

        $reservation->setConfirmed(true);
        $actions->setConfirmed(true);
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
       $priceTTC = $res->getTotalPrice();
       $actionStatus = $actionStatusRepository->actionReservation($id);
    //    $actionStatusObj = $actionStatus[0]; // Accéder à l'objet ActionStatus dans le tableau
      $rCar= $carRepository->find($id);
      $newStock = $res->getCar()->getStock(); // valeur du stock de voiture selectionnée
      if ($res && $actionStatus) {
        if ($res->isConfirmed()) {
            if ($res->getCar()->getStock() > 0) {
                $newStock -=  1;
                
                $res->getCar()->setStock($newStock);
                $res->getCar()->setAvailable(true);
                $actionStatus->setRentedCar(true);
                $actionStatus->setDateRental(new \DateTime());

                $invoice = new Invoice;
                $invoice->setReserve( $res);
                $invoice->setPriceTTC( $priceTTC );
                $invoice->generateInvoiceNumber();
                 // Stocker l'instance de la facture en base de données
                  
                 $entityManager->persist($invoice);
                $entityManager->flush();
                
                return $this->redirectToRoute('app_selection');
            } else {
                $newStock = 0 ;
                $res->getCar()->setStock($newStock);
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



 #[Route("/dashboard/RestitueStock/{id}", name: 'app_restitueStock')]
public function Restitue($id, EntityManagerInterface $entityManager, CarRepository $carRepository, ReservationRepository $reserved, ActionStatusRepository $actionStatusRepository, InvoiceRepository $invoice): RedirectResponse
{
    $reservationCloturees = $actionStatusRepository->ResrvationCloturees(); // Réservations clôturées
    $facture = $invoice->invoiceReservation($id); // Facture en fonction de l'ID de la réservation

    // Récupérer la réservation
    $res = $reserved->find($id);

    // S'assurer que la réservation est trouvée
    if (!$res) {
        throw $this->createNotFoundException('Réservation non trouvée pour l\'ID spécifié.');
    }

    // Récupérer l'état de l'action
    $actionStatus = $actionStatusRepository->actionReservation($id);

    // S'assurer que l'état de l'action est trouvé
    if (!$actionStatus) {
        throw $this->createNotFoundException('État de l\'action non trouvé pour l\'ID de réservation spécifié.');
    }

    // Assurez-vous que $actionStatus est un objet et non un tableau
    if (!is_object($actionStatus)) {
        throw new \Exception('État de l\'action invalide.');
    }

    // Accéder à l'entité de voiture et son stock
    $car = $res->getCar();
    $restitueStock = $car->getStock();

    // Vérifier le stock et effectuer les actions appropriées
    if ($restitueStock < $car->getQuantity()) {
        $restitueStock += 1;
        $car->setStock($restitueStock);
        $actionStatus->setReturnedCar(true);
        $actionStatus->setReturnDate(new \DateTime());
    } else {
        $restitueStock = $car->getQuantity();
        $car->setStock($restitueStock);
    }

    // Persistez les changements dans la base de données
    $entityManager->flush();

    // Retourner une réponse HTTP si nécessaire
    // Vous pouvez retourner une réponse de succès si le traitement s'est bien passé
    // return new Response('Traitement terminé avec succès');
    // Ou rediriger vers une autre page si nécessaire
    // return $this->redirectToRoute('nom_de_la_route');

     return $this->redirectToRoute('app_location');
}






    public function configureDashboard(): Dashboard
    {
        
        return Dashboard::new()
            ->setTitle('DisCars')
            
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
        // yield MenuItem::linkToCrud('Contact', 'fas fa-address-book', Contact::class);
        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }

    
}
