<?php

// src/Controller/AdminController.php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\FileUploader;
use App\Service\Logger;
use App\Service\MessageGenerator;
use App\Service\SiteUpdateManager;
use App\Form\Type\EventType;
use App\Entity\Events;
use App\Entity\EventStatus;

/**
 * @Route("/conservator")
 */
class ConservatorController extends AbstractController
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
     * @Route("/home", name="_conservator_home")
     */
    public function home()
    {
        $this->init();

        return $this->render('conservator/home.html.twig', [
            'user' => $this->user
        ]);
    }

    /**
     * @Route("/ajaxevents", name="_conservator_ajax_event")
     */
    public function ajaxevents( PaginatorInterface $paginator, Request $request )
    {
        $this->init();
        $page = $request->query->get('page', 1);
        $sorts = $request->query->get('sorts');
        $max = 20;

        $eventsAll = $this->em->getRepository(Events::class)->findEvents(['userId'=>$this->user, 'sorts'=>$sorts] );

        $events = $paginator->paginate($eventsAll, $page, $max);

        return $this->render('conservator/ajaxevents.html.twig', [
            'page' => $page,
            'user' => $this->user,
            'events' => $events
        ]);
    }

    /**
     * @Route("/addevent", name="_conservator_add_event")
     */
    public function addevent(Request $request, FileUploader $fileUploader, Logger $logger, SiteUpdateManager $siteUpdateManager, MessageGenerator $messageGenerator)
    {
        $this->init();

        $event = new Events();

        $form = $this->createForm(EventType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();

            $status = $this->em->getRepository(EventStatus::class)->findOneBy(array('id' => 1));

            $event->setUser($this->user);
            $event->setStatus($status);
            $event->setDeleted(false);
			$event->setDateCreated(new \DateTime('now'));

            /** @var UploadedFile $brochureFile */
            $photo1File = $form['photo1']->getData();
            if ($photo1File) {
                $photo1FileName = $fileUploader->upload($photo1File);
                $event->setPhoto1Filename($photo1FileName);
            }

            $this->em->persist($event);
            $this->em->flush();

            $logger->setLog( $this->user, 'event', $event->getId(), 'Dodano nową usterkę', $event->getTitle());

            $siteUpdateManager->notifyOfSiteUpdate("Dodano nowe wydażenie");

            $this->addFlash(
                'success',
                $messageGenerator->getHappyMessage()
            );

            return $this->redirectToRoute('_conservator_home');
        }

        return $this->render('conservator/addevent.html.twig', [
            'user' => $this->user,
            'form' => $form->createView(),
        ]);
    }
}
