<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Repository\CarRepository;
use App\Repository\InvoiceRepository;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class InvoiceController extends AbstractController
{
    #[Route('/invoice', name: 'app_invoice')]
    public function index(InvoiceRepository $invoiceRepository, ReservationRepository $reservation, CarRepository $carRepository): Response
    {

        $tousReservation = $reservation->findAll();
        $tousCars = $carRepository->findAll();
       
        foreach($tousReservation as $val){
            $prixillimite=$val->getPriceunlimitedKm();
            $chauffeur = $val->isOptionDriver();
            $siege = $val->isOptChildSeat();
            $decore= $val->isDecoration();
            $totale= 0;

            if($prixillimite === true ){

                foreach($tousCars as $valeur){
                    $totale += $valeur->getPriceKmUnlimited();
                   
                      
                 }

            }

            if($chauffeur === true ){

                foreach($tousCars as $valeur){
                    $totale += $valeur->getPriceKmUnlimited()+80;
                    
                      
                 }
                       
            }

            if($siege === true ){

                foreach($tousCars as $valeur){
                    $totale += 30;
                      
                 }

                 if($decore === true ){

                    foreach($tousCars as $valeur){
                        $totale += 120;
                          
                     }

                 }

                 else{

                    foreach($tousCars as $valeur){
                        $totale += $valeur->getPriceDay();
                          
                     }

                 }
                       
            }
            
         
          
        }

       
         

        return $this->render('invoice/index.html.twig', [
            'controller_name' => 'InvoiceController',
        ]);
    }
}
