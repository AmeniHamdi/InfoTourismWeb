<?php

namespace App\Repository;

use App\Entity\Reclamaweb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Reclamaweb|null find($id, $lockMode = null, $lockVersion = null)
 * @method Reclamaweb|null findOneBy(array $criteria, array $orderBy = null)
 * @method Reclamaweb[]    findAll()
 * @method Reclamaweb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ReclamawebRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Reclamaweb::class);
    }

    // /**
    //  * @return Reclamaweb[] Returns an array of Reclamaweb objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Reclamaweb
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
