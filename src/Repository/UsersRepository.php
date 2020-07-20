<?php

namespace App\Repository;

use App\Entity\Users;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Events;

/**
 * @method Users|null find($id, $lockMode = null, $lockVersion = null)
 * @method Users|null findOneBy(array $criteria, array $orderBy = null)
 * @method Users[]    findAll()
 * @method Users[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UsersRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Users::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof Users) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function findUsers($arr)
    {
        $query = $this->createQueryBuilder('u');
        $query
            ->select('u')
            ->addSelect("(SELECT count(e2.id) FROM App\Entity\Events as e2 WHERE e2.user = u.id and e2.deleted = 0 ) as eventsCount");

        if(isset($arr['userId'])){
            if($arr['userId']){
                $query
                    ->andWhere('c.user = :user')
                    ->setParameter('user', $arr['userId']);
            }
        }

        if(isset($arr['deleted'])){
            $query
                ->andWhere('u.deleted = :deleted')
                ->setParameter('deleted', $arr['deleted']);
        }

        if(isset($arr['user_type'])){
            $query
                ->andWhere('u.user_type = :user_type')
                ->setParameter('user_type', $arr['user_type']);
        }

        if(isset($arr['sorts'])){
            if($arr['sorts'] == 'name'){
               $query->orderBy('u.name', 'ASC');
            } elseif ($arr['sorts'] == 'done_hight' ){
               $query->orderBy('eventsCount', 'DESC');
            } elseif ($arr['sorts'] == 'done_low' ){
               $query->orderBy('eventsCount', 'ASC') ;
            }
        } else {
            $query->orderBy('u.name', 'ASC');
        }

        return $query
            ->getQuery()
            ->getResult();
    }
}
