<?php

namespace App\Controller;

use App\Repository\ImageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(ImageRepository $imageRepository): Response
    {

 // Liste d'URLs d'images
 $images= $imageRepository->findAll();
 
//  $pictures= $images->getImage1();
//  $images = [
//     '/pictures/voiture1.png',
//     '/pictures/voiture2.jpg',
//     '/pictures/voiture3.jpg',
//     '/pictures/voiture3.jpg',
//     '/pictures/voiture4.jpg',
//     '/pictures/voiture5.jpg',
//     '/pictures/voiture6.jpg',
//     '/pictures/voiture7.jpg',
//     '/pictures/voiture8.jpg',
//     '/pictures/voiture9.jpg',
//     '/pictures/voiture10.jpg',
//     '/pictures/voiture11.jpg',
//     '/pictures/voiture12.jpg',
//     '/pictures/voiture13.jpg',
//     '/pictures/voiture14.jpg',
//     '/pictures/voiture14.jpg',
//     '/pictures/voiture15.jpg',
//     '/pictures/voiture16.jpg',
//     '/pictures/voiture17.jpg',
//     '/pictures/voiture18.jpg',
//     '/pictures/voiture19.jpg',
//     '/pictures/voiture20.png',
//     '/pictures/voiture21.jpg',
//     '/pictures/voiture22.jpg',
//     '/pictures/voiture23.jpg',
//     '/pictures/voiture24.jpg',
//     '/pictures/voiture25.jpg',
//     '/pictures/voiture26.png',
   

//     // Ajoutez autant d'URLs que nécessaire
// ];

// Sélectionnez une image aléatoire
$randomImage = $images[array_rand($images)];


        return $this->render('home/index.html.twig', [
            'randomImage' => $randomImage,
            'pictures' => $images
        ]);
    }
}
