<?php

namespace App\Repository;

use App\Entity\Vinyle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Vinyle|null find($id, $lockMode = null, $lockVersion = null)
 * @method Vinyle|null findOneBy(array $criteria, array $orderBy = null)
 * @method Vinyle[]    findAll()
 * @method Vinyle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VinyleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Vinyle::class);
    }

    // /**
    //  * @return Vinyle[] Returns an array of Vinyle objects
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
    public function findOneBySomeField($value): ?Vinyle
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
