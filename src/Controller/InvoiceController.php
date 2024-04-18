<?php

namespace App\Controller;

use Dompdf\Dompdf;
use App\Entity\Reservation;
use App\Repository\CarRepository;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use App\Repository\ActionStatusRepository;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class InvoiceController extends AbstractController
{
    #[Route('/invoice', name: 'app_invoice')]
    public function index(InvoiceRepository $invoiceRepository, ReservationRepository $reservation, CarRepository $carRepository): Response
    {

        $tousReservation = $reservation->findAll();
        $tousCars = $carRepository->findAll();
       







        return $this->render('invoice/index.html.twig', [
            'controller_name' => 'InvoiceController',
        ]);
    }


   


     // route pour que l'utilisateur télecharge la facture si  établie par Admin
    #[route("invoice/{id}", name: 'app_fichierFacture')]
    public function generateInvoice($id, Dompdf $dompdf, MailerInterface $mailer, ReservationRepository $res, ActionStatusRepository $actionStatusRepository, EntityManagerInterface $entityManager, InvoiceRepository $invoiceRepository): Response
    {
 

        $resInvoice = $invoiceRepository->invoiceReservation($id); // par ID reservation
        
// Vérifier si la réservation existe
if (!$resInvoice) {
    $this->addFlash('alert','<i class="fa-solid fa-triangle-exclamation"></i>La facture sera disponible aprés la restitution de la voiture');
    return $this->redirectToRoute('app_cart_');
}

// Récupérer le nom du fichier PDF depuis la réservation (adaptez cette partie selon votre modèle de données)
$pdfFileName = $resInvoice->getFacturePdf(); // Assurez-vous que cette méthode retourne le nom du fichier

// Vérifier si le nom du fichier PDF est valide
if (!$pdfFileName) {
    $this->addFlash('alert','<i class="fa-solid fa-triangle-exclamation"></i>La facture sera disponible aprés la restitution de la voiture');
    return $this->redirectToRoute('app_cart_');
}

// Définir le chemin complet du fichier PDF dans le sous-dossier 'fichierPdf' du répertoire public
$pdfPath = $this->getParameter('kernel.project_dir') . '/public/' . $pdfFileName;

// Vérifier si le fichier existe
if (!file_exists($pdfPath)) {
    $this->addFlash('alert','<i class="fa-solid fa-triangle-exclamation"></i>La facture sera disponible aprés la restitution de la voiture');
    return $this->redirectToRoute('app_cart_');
}

// Lire le contenu du fichier PDF
$pdfContent = file_get_contents($pdfPath);

// Retourner une réponse HTTP avec le contenu du PDF
return new Response($pdfContent, 200, [
    'Content-Type' => 'application/pdf',
    'Content-Disposition' => 'attachment; filename="facture.pdf"',
]);




  


}     
              
         
    
 
 
    
       
      

        // return $this->render('invoice/index.html.twig', [
        //     'facture' => $invoices,
        // ]);
    }

