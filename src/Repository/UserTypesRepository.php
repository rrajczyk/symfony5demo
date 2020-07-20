<?php

namespace App\Repository;

use App\Entity\UserTypes;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UserTypes|null find($id, $lockMode = null, $lockVersion = null)
 * @method UserTypes|null findOneBy(array $criteria, array $orderBy = null)
 * @method UserTypes[]    findAll()
 * @method UserTypes[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserTypesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UserTypes::class);
    }

    // /**
    //  * @return UserTypes[] Returns an array of UserTypes objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?UserTypes
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
