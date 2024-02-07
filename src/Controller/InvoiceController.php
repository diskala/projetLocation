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


    


    //générer une Facture
    // #[route("invoice/{id}", name: 'app_facture')]
    // public function generateInvoice($id, Dompdf $dompdf, MailerInterface $mailer, ReservationRepository $res, ActionStatusRepository $actionStatusRepository, EntityManagerInterface $entityManager, InvoiceRepository $invoiceRepository): Response
    // {
     
    //     $user = $this->getUser();
    //     $user->getUserIdentifier(); // pour recuperer le mail de user connecter
    //     $userId = $user->getId();
    //     $reserved = $res->find($id);
       
    //     $reservationInvoice = $res->find($id);
    //     $actionStatusInvoice = $actionStatusRepository->actionReservation($id); // par id de reservation<
    //     $invoices = $invoiceRepository->invoiceReservation($id); // par id reservation
        
    //     // $facture = $invoices[0];
        
    //      // Vérifier que des factures ont été trouvées
    // if (!empty($invoices)) {
    //     foreach ($invoices as $invoice) {
    //         // Rendu du PDF
    //         $dompdf->loadHtml($this->renderView('invoice/index.html.twig', ['data' => $invoice]));

    //         // Rendu du PDF
    //         $dompdf->render();

    //         // Stocker le PDF dans le dossier "facture-pdf"
    //         $pdfFilePath = $this->getParameter('kernel.project_dir') . '/public/facture-pdf/' . $invoice['number'] . '.pdf';
    //         file_put_contents($pdfFilePath, $dompdf->output());
    //     }

    //     // Envoi du premier PDF en réponse
    //     $response = new Response($dompdf->output());
    //     $response->headers->set('Content-Type', 'application/pdf');
    //     return $response;
    // } else {
    //     // Gérer le cas où aucune facture n'est trouvée
    //     // Par exemple, rediriger l'utilisateur avec un message d'erreur
    //     return $this->$this->addFlash(
    //        'alert',
    //        'alert', 'la voiture n\'est pas encore restituée'
    //     );
    // }

    //     return $this->render('invoice/index.html.twig', [
    //         'facture' => $invoices,
    //     ]);
    // }
}
