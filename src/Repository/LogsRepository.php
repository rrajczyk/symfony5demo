<?php

namespace App\Repository;

use App\Entity\Logs;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Logs|null find($id, $lockMode = null, $lockVersion = null)
 * @method Logs|null findOneBy(array $criteria, array $orderBy = null)
 * @method Logs[]    findAll()
 * @method Logs[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LogsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Logs::class);
    }

    public function findLogs($arr)
    {
        $query = $this->createQueryBuilder('l');
        $query
            ->andWhere('l.date_created >= :dateStart')
            ->setParameter('dateStart', $arr['dateStart'])
            ->andWhere('l.date_created <= :dateEnd')
            ->setParameter('dateEnd', $arr['dateEnd']." 23:59");

        if($arr['sorts']){
            if($arr['sorts'] == "new"){

               $query->orderBy('l.id', 'DESC');
            } elseif ($arr['sorts'] == "old" ){
               $query->orderBy('l.id', 'ASC');
            }
        } else {
            $query->orderBy('l.id', 'DESC');
        }


        return $query
            ->getQuery()
            ->getResult();

    }
    // /**
    //  * @return Logs[] Returns an array of Logs objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Logs
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
