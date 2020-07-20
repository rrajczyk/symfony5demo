<?php

namespace App\Repository;

use App\Entity\Events;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Events|null find($id, $lockMode = null, $lockVersion = null)
 * @method Events|null findOneBy(array $criteria, array $orderBy = null)
 * @method Events[]    findAll()
 * @method Events[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Events::class);
    }

    // /**
    //  * @return Events[] Returns an array of Events objects
    //  */

    public function findEvents($arr)
    {
        $query = $this->createQueryBuilder('c');
        $query
            ->select('c') ;

        if(isset($arr['userId'])){
            if($arr['userId']){
                $query
                    ->andWhere('c.user = :user')
                    ->setParameter('user', $arr['userId']);
            }
        }

        if(isset($arr['deleted'])){
            if($arr['deleted'] != 'all'){
                if($arr['deleted'] == 0){
                    $query
                        ->andWhere('c.deleted = :deleted')
                        ->setParameter('deleted', 0);
                }

                if($arr['deleted'] == 1){
                    $query
                        ->andWhere('c.deleted = :deleted')
                        ->setParameter('deleted', 1);
                }
            }
        } else {
            $query
                ->andWhere('c.deleted = :deleted')
                ->setParameter('deleted', 0);
        }

        if($arr['sorts']){
            if($arr['sorts'] == 'last'){
               $query->orderBy('c.id', 'DESC');
            } elseif ($arr['sorts'] == 'priority_hight' ){
               $query->orderBy('c.priority', 'DESC');
            } elseif ($arr['sorts'] == 'priority_low' ){
               $query->orderBy('c.priority', 'ASC') ;
            }
        } else {
            $query->orderBy('c.id', 'DESC');
        }

        return $query
            ->getQuery()
            ->getResult();

    }

    /*
    public function findOneBySomeField($value): ?Events
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
