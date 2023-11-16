<?php

namespace App\Controller;

use App\Repository\CarRepository;
use App\Repository\UserRepository;
use App\Repository\ImageRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AllcarsController extends AbstractController
{
    #[Route('/allcars', name: 'app_allcars')]
    public function index(EntityManagerInterface $entityManager, CarRepository $carRepository, ImageRepository $imageRepository, UserRepository $user, ReservationRepository $reservation, Request $request): Response
    {
        return $this->render('allcars/index.html.twig', [
            'images'=> $imageRepository->findcarInImage(),
            'reservations'=>$reservation->jointResCarImage(),
        ]);
    }
}
