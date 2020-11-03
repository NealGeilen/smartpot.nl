<?php

namespace App\Repository;

use App\Entity\PotLog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PotLog|null find($id, $lockMode = null, $lockVersion = null)
 * @method PotLog|null findOneBy(array $criteria, array $orderBy = null)
 * @method PotLog[]    findAll()
 * @method PotLog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PotLogRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PotLog::class);
    }

    // /**
    //  * @return PotLog[] Returns an array of PotLog objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?PotLog
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
