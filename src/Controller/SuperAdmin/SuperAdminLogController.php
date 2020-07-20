<?php

// src/Controller/AdminController.php
namespace App\Controller\SuperAdmin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\Logs;

/**
 * @Route("/superadmin/logs")
 */
class SuperAdminLogController extends AbstractController
{
    private $em;
    private $user;
    private $userId;

    public function init(){
        $this->em = $this->getDoctrine()->getManager();
        $this->user = $this->getUser();
        $this->userId = $this->user->getId();
    }

    /**
     * @Route("/", name="_superadmin_logs")
     */
    public function logs( PaginatorInterface $paginator, Request $request )
    {
        $this->init();
        $dateStart = date("Y-m-d", strtotime("first day of previous month"));
        $dateEnd  = date('Y-m-d');

        return $this->render('superadmin/logs/logs.html.twig', [
            'user' => $this->user ,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd
        ]);
    }

    /**
     * @Route("/ajaxlogs", name="_superadmin_logs_ajax")
     */
    public function ajaxlogs( PaginatorInterface $paginator, Request $request )
    {
        $this->init();

        $page = $request->query->get('page', 1) ;
        $sorts = $request->query->get('sorts');
        $dateStart = $request->query->get('dateStart');
        $dateEnd = $request->query->get('dateEnd');
        $max = 20;

        $logsAll = $this->em->getRepository(Logs::class)->findLogs(['sorts' => $sorts, 'dateStart'=>$dateStart, 'dateEnd'=>$dateEnd ] );

        $logs = $paginator->paginate($logsAll, $page, $max);


        return $this->render('superadmin/logs/ajaxlogs.html.twig', [
            'page' => $page,
            'user' => $this->user,
            'logs' => $logs
        ]);
    }
}
