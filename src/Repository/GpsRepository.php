<?php

namespace App\Repository;

use App\Entity\Gps;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Gps|null find($id, $lockMode = null, $lockVersion = null)
 * @method Gps|null findOneBy(array $criteria, array $orderBy = null)
 * @method Gps[]    findAll()
 * @method Gps[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GpsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Gps::class);
    }

    // /**
    //  * @return Gps[] Returns an array of Gps objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Gps
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
