<?php

namespace App\Repository;

use App\Entity\Vilain;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vilain|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vilain|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vilain[]    findAll()
 * @method Vilain[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VilainRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vilain::class);
    }

    // /**
    //  * @return Vilain[] Returns an array of Vilain objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Vilain
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
