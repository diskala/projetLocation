<?php

namespace App\Controller;

use Stripe\Stripe;
use App\Entity\Car;
use App\Entity\User;
use App\Entity\Invoice;
use Stripe\PaymentIntent;
use App\Entity\Reservation;
use App\Entity\ActionStatus;
use Stripe\Checkout\Session;
use Doctrine\ORM\EntityManager;
use App\Form\ReservationFormType;
use App\Repository\CarRepository;
use Symfony\Component\Mime\Email;
use App\Repository\UserRepository;
use App\Repository\ImageRepository;
use PhpParser\Node\Expr\Cast\Array_;
use Stripe\Exception\ApiErrorException;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\ReservationRepository;
use Symfony\Component\Mime\Part\DataPart;
use App\Repository\ActionStatusRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\HttpFoundation\Response;
use ContainerQVTEl2T\getImageRepositoryService;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bridge\Doctrine\Form\Type\DoctrineType;
use Symfony\Component\Validator\Constraints\ImageValidator;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
 

 
class CartController extends AbstractController
{
    #[Route("/cart", name: "app_cart_")]
    public function index( CarRepository $carRepository,Request $request, SessionInterface $session, UserRepository $userRepository, ReservationRepository $reservation): Response
    {
    
    // $id=$request->query->get('id');
    // Assurez-vous que l'utilisateur est connecté

  $rUser = $this->getUser(); //recuperer le user

     
            // $panier = $session->get('panier', []);
             // $tabPanier=[];

            // foreach ($panier as $id => $quantity) {
                
            //     $tabPanier[]= $reservation->userCarReservation($id);
                   
            // }
 
            // $panier = $session->set('panier', $panier);

            if ($rUser) {
                // $reserveds= $reservation->find($id);
                $userId= $rUser->getId();
                $reserveds= $reservation->userReservation($userId);
               
            return $this->render('cart/index.html.twig', [
                'reservation' => $reserveds,
                'utilisateur' => $rUser,// pour récuperer l'utilisateur
                 
            ]);
        } else {
            // Gérer le cas où l'utilisateur n'est pas connecté
            // Peut-être rediriger vers une page de connexion
            return $this->redirectToRoute('app_login');
        }
    }


    #[Route("/cart/reserved/{id}", name: "reserved")]
    public function add($id, SessionInterface $session, MailerInterface $mailer,EntityManagerInterface $entityManager, Request $request, CarRepository $carRepository, UserRepository $userRepository, ReservationRepository $reservationRepository): Response
      
    { 
    
        $user = $this->getUser(); // pour récupérer le user connecté 
        $rCar=$carRepository->find($id);
       
       $this->denyAccessUnlessGranted('ROLE_USER');
       
       // crée un panier stocker dans la session
       //    $panier=$session->get('panier', []);
     
       //    if(!empty($panier[$id]))
       //    {
       //     $panier[$id]++;
       //    }
       //    else
       //    {
       //     $panier[$id]=1;
       //    }
       //    $session->set('panier', $panier);


         $stock=$rCar->getStock();// pour récuperer la quantité au stock
         $carId=$rCar->getId();  // pour récupérer le ID de la voiture reserver
         $carPrice=$rCar->getPriceDay();
         $stockCar=$rCar->getStock();

         $form = $this->createForm(ReservationFormType::class);
         $form->handleRequest($request);
        
         $rUser= $this->getUser(); // affiche le tableau complet du user
          
         $rUser->getUserIdentifier(); // get l'adress mail connecter
         
         // si le stock est superieur à 0 on peut effectuer la reservation
         if ($stockCar > 0) {

        if($form->isSubmitted() && $form->isValid())
        {



            // dd($form->get('start_date')->getData());
            $reservation= new Reservation();
       
         
         $reservation->setCar($rCar);
         $reservation->setUsers($rUser);// permettre de charger le user connecter
         $reservation->setDayDate(new \DateTime());
         $reservation->setStartDate($form->get('start_date')->getData());
         $reservation->setEndDate($form->get('end_date')->getData());
         $reservation->setBail($form->get('bail')->getData());
         $reservation->setDecoration($form->get('decoration')->getData());
         $reservation->setOptChildSeat($form->get('opt_child_seat')->getData());
         $reservation->setOptionDriver($form->get('option_driver')->getData());
         $reservation->setPriceunlimitedKm($form->get('priceunlimitedKm')->getData());
        //  $reservation->setFichierPdf($form->get('fichierPdf')->getData());
         $reservation->setConfirmed(false);
         $reservation->setStatus(false);
         
         
         
          // Récupérez le fichier PDF
          $pdfFile = $form->get('fichierPdf')->getData();
        
       
 
          // Générez un nom unique pour le fichier
          $fileName = md5(uniqid()) . '.' . $pdfFile->guessExtension();
 
          // Déplacez le fichier dans le répertoire public
          try {
            $pdfFile->move(
                $this->getParameter('kernel.project_dir') . '/var/tmp',
                $fileName
            );
          $reservation->setFichierPdf($fileName);
            
          } catch (FileException $e) {
              // Gérez l'exception si nécessaire
          }
        
     /************************************************************************************* *
              Envois un Mail de confirmation de la reservation
***************************************************************************************/    
         
         $email = (new Email())
         ->from('projet@projet.com')
         ->to( $rUser->getUserIdentifier())
       
         ->subject('Time for Symfony Mailer!')
         ->text('Bonjour '  . ', votre produit réservé est : ' . $rCar->getBrand())
    ->html('<p>Bonjour ' . ', votre produit réservé est : ' . $rCar->getBrand() . '</p>');
         $mailer->send($email);
 
 
      // si la voiture est reservé mise à jour de la nouvelle valeur de quantité au stock 
    

/************************************************************************************* *
              Créez une nouvelle facture et associez-la à la réservation
***************************************************************************************/

       
/******************************************************************************************
 * ****************************************************************************************
 */
 
// Créez une session de paiement avec Stripe
Stripe::setApiKey($_ENV['STRIPE_SECRET_KEY']);
$checkoutSession = Session::create([
    'payment_method_types' => ['card'],
    'line_items' => [
        [
            'price_data' => [
                'currency' => 'eur',
                'product_data' => [
                    'name' => 'Réservation de voiture', // Nom de votre produit
                ],
                'unit_amount' => $rCar->getBail() * 100, // Montant en centimes
            ],
            'quantity' => 1,
        ],
    ],
    'mode' => 'payment',
    'success_url' => $this->generateUrl('accepter', ['id' => $id], UrlGeneratorInterface::ABSOLUTE_URL),
    'cancel_url' => $this->generateUrl('annuler', ['id' => $id], UrlGeneratorInterface::ABSOLUTE_URL),
   
 
]);

// Associez l'ID de la session de paiement à la réservation
$reservation->setStripeSessionId($checkoutSession->id);

 
/*****************************************************************************************
 * **************************************************************************************
 */
 
 // Enregistrez la facture et la réservation dans la base de données
 

 $entityManager->persist($reservation);
 $entityManager->flush();
 
 // Redirigez l'utilisateur vers la page de paiement Stripe
 return $this->redirect($checkoutSession->url);

        //  $resId=$reservation->getId();
     
        //  return $this->redirectToRoute('app_cart_', ['userId' => $nouvelId]);
         
        
       } 
     
       }

       elseif ($stockCar === 0) {
        // Si le stock est 0, définissez la disponibilité sur false
        $rCar->setAvailable(false);
        $entityManager->flush();

        // Message flash indiquant que la voiture n'est pas disponible
        $this->addFlash('alert', '<i class="fa-solid fa-triangle-exclamation"></i>La voiture n\'est plus disponible  ');
    }
  
 
    

   
       
        return $this->render('cart/reserved.html.twig', [
            'reserved'=>$carRepository->findcarInImageById($id),
             
            'user'=>$user ,
            'reservationForm'=>$form->createView(),
            
            
        ]);
        
        


       
        
    }
    
    // #[Route("/cart/remove/{id}", name: "remove")]
    // public function remove($id, SessionInterface $session, ReservationRepository $reservation, EntityManagerInterface $entityManager)
    // {

       // Convertir la clé en chaîne (si nécessaire)
    //    $id = (string) $id;

       // Récupérer la réservation à partir du Repository
    //    $reservations = $reservation->find($id);

    //    if (!$reservations) {
    //        throw $this->createNotFoundException('La réservation avec l\'ID ' . $id . ' n\'existe pas.');
    //    }

    //    // Supprimer la réservation
    //    $entityManager->remove($reservations);
    //    $entityManager->flush();

    //    $this->addFlash('success', 'La réservation a été supprimée avec succès.');

    //    return $this->redirectToRoute('app_allcars_'); // Redirigez vers la page des réservations après la suppression

       
        // $panier = $session->get('panier', []);
    
        // Convertir la clé en chaîne (si nécessaire)
        // $id = (string) $id;
    
        // if (array_key_exists($id, $panier)) {
        //     unset($panier[$id]);
        // }
    
        // $session->set('panier', $panier);
    
     
    // }



    
    #[Route("/cart/modifier/{id}", name: "modifier")]
    public function modifier($id,SessionInterface $session, EntityManagerInterface $entityManager, Request $request, ReservationRepository $reservationRepository, CarRepository $carRepository, ActionStatusRepository $actionStatusRepository): Response
    {
       
        $reservations = $reservationRepository->find($id);
        $tabActs= $actionStatusRepository->actionReservation($id);
        // $acts = $tabActs[0];
             
        if (!$reservations) {
            throw $this->createNotFoundException('Réservation introuvable');
        }

        // Vérifiez si l'utilisateur a le droit de modifier la réservation
        // Par exemple, vous pouvez vérifier si l'utilisateur possède la réservation
        // ou a le rôle nécessaire pour modifier les réservations.

        $form = $this->createForm(ReservationFormType::class, $reservations);
        $form->handleRequest($request);
    
         // si la reservation n'est pas encore confirmé ou la date de debut et != à la date d'aujourd'hui on peut toujours modifier les dates 
        
        if ($form->isSubmitted() && $form->isValid())
        { 
          
            // Mettez à jour la réservation avec les données modifiées
            $reservations->setStartDate($form->get('start_date')->getData());
            $reservations->setEndDate($form->get('end_date')->getData());
            $reservations->setBail($form->get('bail')->getData());
            $reservations->setDecoration($form->get('decoration')->getData());
            $reservations->setOptChildSeat($form->get('opt_child_seat')->getData());
            $reservations->setOptionDriver($form->get('option_driver')->getData());
            $reservations->setPriceunlimitedKm($form->get('priceunlimitedKm')->getData());

            // Récupérez le fichier PDF
          $pdfFile = $form->get('fichierPdf')->getData();
        
       
 
          // Générez un nom unique pour le fichier
          $fileName = md5(uniqid()) . '.' . $pdfFile->guessExtension();
 
          // Déplacez le fichier dans le répertoire public
          try {
            $pdfFile->move(
                $this->getParameter('kernel.project_dir') . '/public/fichier_pdf',
                $fileName
            );
            $reservations->setFichierPdf($fileName);
            
          } catch (FileException $e) {
              // Gérez l'exception si nécessaire
          }

            // Persister les modifications dans la base de données
            $entityManager->flush();

            // Redirigez vers la page du panier ou toute autre page appropriée
            // return $this->redirectToRoute('app_cart_',  ['id' => $id]);
            return $this->redirectToRoute('app_cart_');
         
        } 
        
         
        return $this->render('cart/modifier.html.twig', [
            'reservation' => $reservations,
            'formModification' => $form->createView(),
        ]);
    }


    #[Route("/cart/success/{id}", name: 'accepter')]
     
    public function paymentSuccess($id, EntityManagerInterface $entityManager, ReservationRepository $res, CarRepository $carRepository, ActionStatusRepository $actionStatusRepository)
{
    
  // Récupérez la réservation en fonction de l'ID
  $reservation = $entityManager->getRepository(Reservation::class)->userCarReservation($id);
  
  // Vérifiez si la réservation existe
  if (!$reservation || empty($reservation)) {
      // Gérer le cas où la réservation n'existe pas, par exemple, rediriger avec un message d'erreur
      return $this->redirectToRoute('app_home');
  }
 

//   $reserved = $reservation[0]; // Récupérez le premier élément du tableau
$reserved = end($reservation);
 
  if($reserved->isDecoration()){
    $valDecoration= $reserved->getCar()->getPriceDecoration();
}
else{
    $valDecoration= 0;
}


if($reserved->isOptionDriver()){
    $valOptionDriver= $reserved->getCar()->getPriceDriver();
}
else{
    $valOptionDriver= 0;
}

if($reserved->isOptChildSeat()===true){
    $valSeatChild= $reserved->getCar()->getPriceSeatChild();
    
}
else{
    $valSeatChild= 0;
}

if($reserved->getPriceunlimitedKm()){
    $valKmIllimited= $reserved->getCar()->getPriceKmUnlimited();
    $totalPrice= $valKmIllimited+ $valOptionDriver + $valDecoration + $valSeatChild;
}
else{
    $valKm= $reserved->getCar()->getPriceDay();
    $totalPrice= $valKm + $valOptionDriver + $valDecoration + $valSeatChild;
}
  // Mettez à jour le statut de la réservation en "canceled"
  $reserved->setStatus(true);
  $reserved->setTotalPrice($totalPrice);

  $actionStatus = new ActionStatus;

  $actionStatus->setReserved($reserved);
  $actionStatus->setRentedCar(false);
  $actionStatus->setConfirmed(false);
  $actionStatus->setReturnedCar(false);
  $entityManager->persist($actionStatus);
  
  $entityManager->flush();

 
  // Enregistrez les modifications dans la base de données
  
  $resId = $reserved->getId();
    // Redirigez l'utilisateur vers la page de confirmation de réservation
    // return $this->redirectToRoute('app_cart_', ['id' => $resId]);
    return $this->redirectToRoute('app_cart_');
 
     }
    
 


#[Route("/cart/cancel/{id}", name: 'annuler')]
public function paymentCancel()
{



    // Redirigez l'utilisateur vers la page de réservation avec un message d'échec de paiement
    $this->addFlash('danger', 'Le paiement a été annulé.');
    return $this->redirectToRoute('reserved');
}
}
