<?php

namespace App\Controller;

use App\Form\SearchType;
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
    #[Route('/allcars', name: 'app_allcars_')]
    public function index(EntityManagerInterface $entityManager, CarRepository $carRepository, ImageRepository $imageRepository, UserRepository $user, ReservationRepository $reservation, Request $request): Response
    {

// dd($carRepository->carsSiDispo());//toutes les voitures disponible
        $allCars=$carRepository->carsSiDisponible();
        $form=$this->createForm(SearchType::class);
        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid()) {

            $rechercheMarques=$form->get('marques')->getData();
            $rechercheCategories=$form->get('categories')->getData();
           if(!empty($rechercheMarques) && !empty($rechercheCategories)){
            $allCars=$carRepository->searchMarqueCategory($rechercheMarques, $rechercheCategories);
            
           }
           else {
            if(!empty($rechercheMarques) && empty($rechercheCategories) ){
                $allCars=$carRepository->searchMarque($rechercheMarques);
            }
            else {
                if(!empty($rechercheCategories) && empty($rechercheMarques)){
                    $allCars=$carRepository->searchCategory($rechercheCategories); 
                }
                else{
                    $allCars=$carRepository->carsSiDisponible();
                }
            }
           }
            
           
           
           
            
        }


        return $this->render('allcars/index.html.twig', [
            // 'allCars'=> $carRepository->findcarInImage(),
            'allcars'=>$allCars,
             'search'=> $form->createView()
        ]);
    }

    #[Route("allcars/onecar/{id}", name: "onecar")]
    public function oneCar($id, CarRepository $carRepository,Request $request, ImageRepository $imageRepository):Response
    {
        //  $images=$imageRepository->findcarInImage();
        //  dd($images);
        
        
        return $this->render('allcars/onecar.html.twig', [
            'onecar'=> $carRepository->findcarInImageById($id),
            
        ]);

    }

}
