<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
 

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function index(EntityManagerInterface $entityManagerInterface, Request $request, ContactRepository $contactRepository): Response
    {
        
        $contactExist= $contactRepository->findOneBy([], ['id' => 'DESC']);
       

        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        // dd($form->get('objet')->getData());
        if($form->isSubmitted() && $form->isValid()){


            

             $contact = new Contact();

             $contact->setFirstname($form->get('firstname')->getData());
             $contact->setLastname($form->get('lastname')->getData());
             $contact->setEmail($form->get('email')->getData());
             $contact->setPhone($form->get('phone')->getData());
             $contact->setObjet($form->get('objet')->getData());
             $contact->setMessage($form->get('message')->getData());
             $contact->setStatusMessage(false);
             $contact->setDateContact(new DateTime());

             $entityManagerInterface->persist($contact);
             $entityManagerInterface->flush();
             
             $this->addFlash('alert', '<i class="fa-sharp fa-solid fa-hands-clapping"></i>VOTRE MESSAGE A ÉTÉ ENVOYÉ AVEC SUCCÈS');
             return $this->redirectToRoute('app_contact');

        }
         




        return $this->render('contact/index.html.twig', [
            'contactForm' => $form->createView(),
            'contactExist' => $contactExist
        ]);
    }




    public static function getEntityFqcn(): string
    {
        return Contact::class;
    }
}
