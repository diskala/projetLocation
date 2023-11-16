<?php

namespace App\Controller;

use App\Repository\CarRepository;
use App\Repository\ImageRepository;
use App\Repository\ReservationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(EntityManagerInterface $entityManager, CarRepository $carRepository, ImageRepository $imageRepository, UserRepository $user, ReservationRepository $reservation, Request $request): Response
    {
        
     

        

        return $this->render('home/index.html.twig', [
            'controle'=>"",
            
            
        ]);
    }



   
}
