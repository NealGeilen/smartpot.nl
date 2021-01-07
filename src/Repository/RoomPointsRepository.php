<?php

namespace App\Repository;

use App\Entity\RoomPoints;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RoomPoints|null find($id, $lockMode = null, $lockVersion = null)
 * @method RoomPoints|null findOneBy(array $criteria, array $orderBy = null)
 * @method RoomPoints[]    findAll()
 * @method RoomPoints[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RoomPointsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RoomPoints::class);
    }

    // /**
    //  * @return RoomPoints[] Returns an array of RoomPoints objects
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
    public function findOneBySomeField($value): ?RoomPoints
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
