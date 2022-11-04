<?php

namespace App\Repository;

use App\Entity\Address;
use App\Entity\Truck;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Address|null find($id, $lockMode = null, $lockVersion = null)
 * @method Address|null findOneBy(array $criteria, array $orderBy = null)
 * @method Address[]    findAll()
 * @method Address[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    /**
     * @return Address[] Returns an array of Address objects
     */
    
    public function findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
    {
        return $this->createQueryBuilder('a')
            // ->andWhere()
            // ->setParameter('val', $criteria)
            // ->orderBy()
            // ->setMaxResults()
            // ->orderBy()
            // ->setMaxResults()
            ->getQuery()
            ->getResult()
        ;
    }
    //jointure avec truck.id spécifique
    /**
     * @return Address[] Returns an array of Address objects
     */
    
    public function findMyAddresses($value)
    {
        return $this->createQueryBuilder('a')
            ->join('a.truck','t', 'WITH', 't.id = :val')
            ->setParameter ( 'val', $value)
            // ->andWhere()
            // ->orderBy()
            // ->setMaxResults()
            // ->orderBy()
            // ->setMaxResults()
            ->getQuery()
            ->getResult()
        ;
    }
    

    /**
     * @return Address[] Returns an array of Address objects
     */
    // Pour récupérer toutes les adresses d'un Truck en particulier
    public function skipAddresses(): array
    {
        return $this->createQueryBuilder('a')
            ->select('a.street_number','a.street_name','a.post_code','a.city','a.days_of_presence')
            // ->andWhere()
            // ->select('a.id', 'a.street_number','a.street_name','a.post_code','a.city','t.name_truck')
            // ->leftJoin('App\Entity\Truck', 't', 'WITH', 'a.id = t.id')
            ->getQuery()
            ->getResult()
        ;
    }





    
}
