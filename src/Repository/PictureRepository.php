<?php

namespace App\Repository;

use App\Entity\Picture;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Picture>
 *
 * @method Picture|null find($id, $lockMode = null, $lockVersion = null)
 * @method Picture|null findOneBy(array $criteria, array $orderBy = null)
 * @method Picture[]    findAll()
 * @method Picture[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PictureRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Picture::class);
    }

    public function save(Picture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Picture $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    //    /**
    //     * @return Picture[] Returns an array of Picture objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('p.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Picture
    //    {
    //        return $this->createQueryBuilder('p')
    //            ->andWhere('p.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }

    /**
     * @return Picture[] Returns an array of Address objects
     */
    // Pour récupérer toutes les images d'un Truck en particulier
    public function skipPictures($value): array
    {
        return $this->createQueryBuilder('p')
            ->select('p.name')
            ->innerJoin('p.truck', 't', 'WITH', 't.id = :val')
            ->setParameter('val', $value)
            // ->andWhere()
            // ->select('a.id', 'a.street_number','a.street_name','a.post_code','a.city','t.name_truck')
            // ->leftJoin('App\Entity\Truck', 't', 'WITH', 'a.id = t.id')
            ->getQuery()
            ->getResult();
    }
}

    // public function byTruck($value, $type)
    // {
    //     return $this->createQueryBuilder('p')
    //         ->select('p.product_name', 'p.type', 'p.price', 'p.description')
    //         ->join('p.truck','t', 'WITH', 't.id = :val')
    //         ->setParameter ( 'val', $value)
    //         ->where('p.type = :type')
    //         ->setParameter ( 'type', $type)
    //         // ->andWhere('p.exampleField = :val')
    //         // ->setParameter('val', $value)
    //         // ->orderBy('p.id', 'ASC')
    //         // ->setMaxResults(10)
    //         ->getQuery()
    //         ->getResult()
    //     ;
    // }