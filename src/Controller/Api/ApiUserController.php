<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Users;

/**
 * @Route("/api/users")
 */
class ApiUserController extends AbstractController
{
    private $em;

    public function init(){
        $this->em = $this->getDoctrine()->getManager();
    }

    /**
     * @Route("/get", name="_api_users_get")
     */
    public function apiusersget( PaginatorInterface $paginator, Request $request )
    {
        $this->init();
        $page = $request->query->get('page', 1);
        $userId = $request->query->get('userId');
        $sorts = $request->query->get('sorts');
        $deleted = $request->query->get('deleted');
        $max = $request->query->get('max', 20);

        $usersAll = $this->em->getRepository(Users::class)->findUsers([ 'sorts'=>$sorts, 'deleted'=>$deleted, 'userId'=>$userId ]);

        $users = $paginator->paginate($usersAll, $page, $max);

        $data = $this->container->get('serializer')->serialize( [
                    'code' => 200,
                    'message' => 'OK',
                    'result' => $users,
                ], 'json', ['groups' => ['api_data']]) ;

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}