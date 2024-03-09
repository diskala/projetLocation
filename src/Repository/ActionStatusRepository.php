<?php

namespace App\Repository;

use App\Entity\ActionStatus;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ActionStatus>
 *
 * @method ActionStatus|null find($id, $lockMode = null, $lockVersion = null)
 * @method ActionStatus|null findOneBy(array $criteria, array $orderBy = null)
 * @method ActionStatus[]    findAll()
 * @method ActionStatus[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ActionStatusRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ActionStatus::class);
    }


// en fonction de id reservation
    public function actionReservation($id)
    {
        return $this->createQueryBuilder('a')
                   ->leftJoin('a.reserved', 'r')
                   ->andWhere('r.id = :id')
                   ->setParameter('id', $id)
                   ->getQuery()
                   ->getOneOrNullResult(); // Utilisez getOneOrNullResult() au lieu de getResult()
               
    }

    



    public function actiones()
    {
        return $this->createQueryBuilder('a')
                   ->leftJoin('a.reserved', 'r')
                   ->getQuery()
                   ->getResult()
               ;
    }

    // recupérer les reservation actuellement en location 
    public function CarEnLocation()
    {
        return $this->createQueryBuilder('a')
                   ->leftJoin('a.reserved', 'r')
                   ->where('a.returnedCar = :returnedCar')
                   ->andWhere('a.rentedCar = :rentedCar')
                   ->setParameter('returnedCar' , false)
                   ->setParameter('rentedCar' , true)
                   ->getQuery()
                   ->getResult()
               ;
    }


    // actions  reservations cloturées
    public function ResrvationCloturees()
    {
        return $this->createQueryBuilder('a')
                //    ->leftJoin('a.reserved', 'r')
                   ->where('a.returnedCar = :returnedCar')
                   ->andWhere('a.rentedCar = :rentedCar')
                   ->setParameter('returnedCar' , true)
                   ->setParameter('rentedCar' , true)
                   ->orderBy('a.returnDate' , 'DESC')
                   ->getQuery()
                   ->getResult()
               ;
    }




    // recherche une reservation coloturée par email utilisateur

    public function actionClotureesEmail($email)
    {
        return $this->createQueryBuilder('a')
                   ->leftJoin('a.reserved', 'r')
                   ->leftJoin('r.users', 'u') // Rejoindre la relation avec l'entité User
                   ->andWhere('u.email = :email') // Filtrer en fonction de l'email de l'utilisateur
                   ->setParameter('email', $email)
                   ->getQuery()
                   ->getResult(); // Utilisez getOneOrNullResult() au lieu de getResult()
            
                   

    }

     // recherche une reservation coloturée par date de location utilisateur

     public function actionClotureesDateDebut($dateDebut)
     {
         return $this->createQueryBuilder('a')
                    ->leftJoin('a.reserved', 'r')
                    ->andWhere('a.dateRental = :dateRental')
                    ->setParameter('dateRental', $dateDebut)
                    ->getQuery()
                    ->getResult(); // Utilisez getOneOrNullResult() au lieu de getResult()
                
     }

     public function actionClotureesDateDebutEtRetour($dateDebuts,$dateRetours)
     {
         return $this->createQueryBuilder('a')
                    ->leftJoin('a.reserved', 'r')
                    ->andWhere('a.dateRental = :dateRental')
                    ->andWhere('a.returnDate = :returnDate')
                    ->setParameter('dateRental', $dateDebuts)
                    ->setParameter('returnDate', $dateRetours)
                    ->getQuery()
                    ->getResult(); // Utilisez getOneOrNullResult() au lieu de getResult()
                
     }


     public function actionClotureesDateRetour($dateRetour)
     {
         return $this->createQueryBuilder('a')
                    ->leftJoin('a.reserved', 'r')
                    ->andWhere('a.returnDate = :returnDate')
                    ->setParameter('returnDate', $dateRetour)
                    ->getQuery()
                    ->getResult(); // Utilisez getOneOrNullResult() au lieu de getResult()
                
     }





//    /**
//     * @return ActionStatus[] Returns an array of ActionStatus objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?ActionStatus
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
