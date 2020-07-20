<?php

namespace App\Repository;

use App\Entity\EventPriorities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EventPriorities|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventPriorities|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventPriorities[]    findAll()
 * @method EventPriorities[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventPrioritiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventPriorities::class);
    }

    // /**
    //  * @return EventPriorities[] Returns an array of EventPriorities objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?EventPriorities
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
