<?php

namespace App\Repository;

use App\Entity\Car;
use App\Entity\Image;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Car>
 *
 * @method Car|null find($id, $lockMode = null, $lockVersion = null)
 * @method Car|null findOneBy(array $criteria, array $orderBy = null)
 * @method Car[]    findAll()
 * @method Car[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CarRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Car::class);
    }

//    /**
//     * @return Car[] Returns an array of Car objects
//     */

// public function findcarIn()
// {
//     return $this->createQueryBuilder('c')
//         ->leftJoin('c.images', 'i') // Assuming 'books' is the property name in Author entity
//         ->addSelect('i')
//         ->getQuery()
//         ->getResult();

public function findcar()
{
    return $this->createQueryBuilder('c')
        ->leftJoin('c.image', 'i')  
        ->addSelect('i')
        ->getQuery()
        ->getResult();
        
 
}       



// Effectuer une jointure tables Car et Image
public function findcarInImage()
{
    return $this->createQueryBuilder('c')
        ->leftJoin('c.image', 'i')  
        ->addSelect('i')
        ->getQuery()
        ->getResult();
        
 
}       
 
// Effectuer une jointure tables Car et Image plus choix par ID
public function findcarInImageById($id)
{
    return $this->createQueryBuilder('c')
        ->leftJoin('c.image', 'i') 
        -> leftJoin('c.reservations', 'r') 
        ->addSelect('i')
        ->addSelect('r')
        -> where('c.id= :id')
        ->setParameter('id', $id)
        ->getQuery()
        ->getResult();
        
 
}

// Effectuer un affichage de toutes les voitures disponible
public function carsSiDisponible()
{
    return $this->createQueryBuilder('c')
    ->leftJoin('c.image', 'i') 
    ->addSelect('i')
        -> where('c.available= :available')
        ->setParameter('available', true)
        ->getQuery()
        ->getResult();
        


}

// fonction retourne nombre de voitures disponible
public function NombrecarsDisponible()
{
    return $this->createQueryBuilder('c')
    ->leftJoin('c.image', 'i') 
    ->addSelect('i')
    
        -> where('c.available= :available')
        
        ->setParameter('available', true)
        ->select('COUNT(c)')
        ->getQuery()
        ->getResult();
        


}

// effectuer un affichage de toutes les voitures disponible par leur ID
public function carsSiDispo($id)
{
    return $this->createQueryBuilder('c')
    ->leftJoin('c.image', 'i') 
    ->addSelect('i')
        ->where('c.id > :id')
        -> andWhere('c.available= :available')
        ->setParameter('id', $id)
        ->setParameter('available', true)
        ->getQuery()
        ->getResult();
        


}

// recherche des voitures disponible par marque et categories
public function searchMarqueCategory($marques, $categorys){

    return $this->createQueryBuilder('c')
    ->leftJoin('c.image', 'i') 
    ->addSelect('i')
        // -> andWhere('c.available= :available')
        ->andWhere('c.brand = :marque')
        ->andWhere('c.category = :category')
        // ->setParameter('available', true)
        ->setParameter('marque', $marques)
        ->setParameter('category', $categorys)
        ->getQuery()
        ->getResult();


}

// recherche de voiture par Marque parmis toutes les voitures disponible
public function searchMarque($marque){

    return $this->createQueryBuilder('c')
    ->leftJoin('c.image', 'i') 
    ->addSelect('i')
        -> andWhere('c.available= :available')
        ->andWhere('c.brand = :marque')
        ->setParameter('available', true)
        ->setParameter('marque', $marque)
        ->getQuery()
        ->getResult();


}

// recherche de voitures disponible  par categorie 
public function searchCategory($category){

    return $this->createQueryBuilder('c')
    ->leftJoin('c.image', 'i') 
    ->addSelect('i')
        -> andWhere('c.available= :available')
        ->andWhere('c.category = :category')
        ->setParameter('available', true)
        ->setParameter('category', $category)
        ->getQuery()
        ->getResult();


}
// }


//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('c.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Car
//    {
//        return $this->createQueryBuilder('c')
//            ->andWhere('c.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
