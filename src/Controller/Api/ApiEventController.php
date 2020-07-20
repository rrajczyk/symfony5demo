<?php

namespace App\Controller\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\AbstractObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use App\Entity\Events;

/**
 * @Route("/api/events")
 */
class ApiEventController extends AbstractController
{
    private $em;

    public function init(){
        $this->em = $this->getDoctrine()->getManager();
    }

    /**
     * @Route("/get", name="_api_events_get")
     */
    public function apieventsget( PaginatorInterface $paginator, Request $request )
    {
        $this->init();
        $page = $request->query->get('page', 1);
        $userId = $request->query->get('userId');
        $sorts = $request->query->get('sorts');
        $deleted = $request->query->get('deleted');
        $max = $request->query->get('max', 20);

        $eventsAll = $this->em->getRepository(Events::class)->findEvents([ 'sorts'=>$sorts, 'deleted'=>$deleted, 'userId'=>$userId ]);

        $events = $paginator->paginate($eventsAll, $page, $max);

        $data = $this->container->get('serializer')->serialize( [
                    'code' => 200,
                    'message' => 'OK',
                    'result' => $events,
                ], 'json', ['groups' => ['api_data']]) ;

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
}