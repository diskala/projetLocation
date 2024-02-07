<?php

namespace App\Repository;

use App\Entity\Reservation;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Reservation>
 *
 * @method Reservation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reservation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reservation[]    findAll()
 * @method Reservation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReservationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reservation::class);
    }

    public function reservationById($id)
    {
        return $this->createQueryBuilder('r')
        ->leftJoin('r.car' , 'c')
        ->leftJoin('r.users', 'u')
        ->addSelect('u')
        ->addSelect('c')
        ->where('r.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult();
    }
    // jointure entity reservation avec user et car

    public function jointResCarImage()
    {
        return $this->createQueryBuilder('r')
        ->leftJoin('r.car' , 'c')
        ->leftJoin('r.users', 'u')
        ->getQuery()
        ->getResult();
    }


    // methode retourne reservation par id se entity Car
    public function userCarReservation($id)
{
    return $this->createQueryBuilder('r')
        ->leftJoin('r.car', 'c') 
        ->leftJoin('r.users', 'u')
        // ->addSelect('c')
        // ->addSelect('u')
        ->where('c.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult();
}

// retourne reservation par id
public function Reservations($id)
{
    return $this->createQueryBuilder('r')
        ->where('r.id = :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult();
}


// selectionné toutes les reservations par order de date ASC
public function Reservationdashboard()
{
    return $this->createQueryBuilder('r')
        // Si vous voulez filtrer par une date spécifique, décommentez la ligne suivante et remplacez 'YYYY-MM-DD' par la date souhaitée
        // ->where('r.dayDate = :dayDate')
        // ->setParameter('dayDate', new DateTime('YYYY-MM-DD'))
        ->orderBy('r.dayDate', 'DESC')
        ->getQuery()
        ->getResult();
}


// reservations status null
public function ReservationNull()
{
    return $this->createQueryBuilder('r')
        // Si vous voulez filtrer par une date spécifique, décommentez la ligne suivante et remplacez 'YYYY-MM-DD' par la date souhaitée
        ->where('r.status = :status OR r.status IS NULL')
        // ->setParameter('dayDate', new DateTime('YYYY-MM-DD'))
        ->setParameter('status', '')
        ->orderBy('r.dayDate', 'ASC')
        ->getQuery()
        ->getResult();
}

// reservations status accepter
public function ReservationAccepted()
{
    return $this->createQueryBuilder('r')
        ->leftJoin('r.actionStatus', 'a') // Join avec l'entité ActionStatus, 'as' est l'alias de la jointure
        // Si vous voulez filtrer par une date spécifique, décommentez la ligne suivante et remplacez 'YYYY-MM-DD' par la date souhaitée
        ->where('r.status = :status')
        // ->andWhere('r.dayDate = :dayDate')
        // ->setParameter('dayDate', new DateTime('YYYY-MM-DD'))
        ->setParameter('status', true)
        ->orderBy('r.id', 'DESC')
        ->getQuery()
        ->getResult();
}

public function ReservationNonConfirmed()
{
    return $this->createQueryBuilder('r')
        // Si vous voulez filtrer par une date spécifique, décommentez la ligne suivante et remplacez 'YYYY-MM-DD' par la date souhaitée
        ->where('r.Confirmed = :Confirmed')
        // ->andWhere('r.dayDate = :dayDate')
        // ->setParameter('dayDate', new DateTime('YYYY-MM-DD'))
        ->setParameter('Confirmed', false)
        // ->orderBy('r.id', 'DESC')
        ->getQuery()
        ->getResult();
}


// toutes les reservations confirmées
public function ReservationConfirmed()
{
    return $this->createQueryBuilder('r')
        // Si vous voulez filtrer par une date spécifique, décommentez la ligne suivante et remplacez 'YYYY-MM-DD' par la date souhaitée
        ->where('r.Confirmed = :Confirmed')
        ->andWhere('r.start_date >= :today')
        ->setParameter('today', new DateTime('today'))
        // ->setParameter('dayDate', new DateTime('YYYY-MM-DD'))
        ->setParameter('Confirmed', true)
        ->orderBy('r.start_date', 'ASC')
        ->getQuery()
        ->getResult();
}


// public function Reservation()
// {
//     return $this->createQueryBuilder('r')
//         ->leftJoin('r.car', 'c') 
//         ->leftJoin('r.users', 'u')
//         ->addSelect('c')
//         ->addSelect('u')
//         ->where('r.id = :id')
//         ->setParameter('id', $id)
//         ->getQuery()
//         ->getResult();
// }
 
 
     
//    /**
//     * @return Reservation[] Returns an array of Reservation objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('r.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Reservation
//    {
//        return $this->createQueryBuilder('r')
//            ->andWhere('r.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
