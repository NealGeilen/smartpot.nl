<?php

namespace App\Repository;

use App\Entity\Pot;
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

    public function getLatestLog(Pot $pot): ?PotLog
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.Pot = :val')
            ->setParameter('val', $pot->getId())
            ->orderBy("p.addedDate", "DESC")
            ->setMaxResults(1)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function getTimeLineData(Pot $pot): ?array
    {
        $aResponse = $this->createQueryBuilder('p')
        ->andWhere('p.Pot = :val')
        ->setParameter('val', $pot->getId())
        ->select(array('DATE_FORMAT(p.addedDate, \'%d-%m-%Y\') as date', 'AVG(p.Humidity) as Humidity', 'AVG((p.Luminosity1 + p.Luminosity2 + p.Luminosity3) / 3) AS Luminosity1'))
        ->orderBy("p.addedDate", "DESC")
        ->setMaxResults(14)
        ->groupBy("date")
        ->getQuery()
        ->getResult();
        $aData = [];
        foreach ($aResponse as $aRecord){
            $aData[$aRecord["date"]] = $aRecord;
        }

        return $aData;
    }
}
