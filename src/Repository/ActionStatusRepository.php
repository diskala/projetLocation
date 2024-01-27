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
                   ->getResult()
               ;
    }

    



    public function actiones()
    {
        return $this->createQueryBuilder('a')
                   ->leftJoin('a.reserved', 'r')
                   ->getQuery()
                   ->getResult()
               ;
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
