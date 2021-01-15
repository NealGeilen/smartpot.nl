<?php

namespace App\Repository;

use App\Entity\Pot;
use App\Entity\PotLog;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Pot|null find($id, $lockMode = null, $lockVersion = null)
 * @method Pot|null findOneBy(array $criteria, array $orderBy = null)
 * @method Pot[]    findAll()
 * @method Pot[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PotRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Pot::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof Pot) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

   /**
    * @return Pot[] Returns an array of Pot objects
    */
    public function findByOwner(UserInterface $user)
    {
        return $this->createQueryBuilder('p')
            ->select("p.Name", "p.url", "p.uuid", "p.id")
            ->andWhere('p.Owner = :owner')
            ->setParameter(":owner", $user->getId())
            ->orderBy('p.id', 'ASC')
            ->getQuery()
            ->getResult()
        ;
    }


    /*
    public function findOneBySomeField($value): ?Pot
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
