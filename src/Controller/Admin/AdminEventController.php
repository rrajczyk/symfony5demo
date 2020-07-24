<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\FileUploader;
use App\Service\Logger;
use App\Service\MessageHappyGenerator;
use App\Form\Type\EventCommentType;
use App\Form\Type\EventEditType;
use App\Entity\Users;
use App\Entity\Events;
use App\Entity\EventStatus;
use App\Entity\EventComments;

/**
 * @Route("/admin/events")
 */
class AdminEventController extends AbstractController
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
     * @Route("/", name="_admin_events")
     */
    public function events( PaginatorInterface $paginator, Request $request )
    {
        $this->init();

        $users = $this->em->getRepository(Users::class)->findBy(['user_type' => 3, 'deleted' => 0], ['name'=>'ASC'] );

        return $this->render('admin/events/events.html.twig', [
            'user' => $this->user,
            'users' => $users
        ]);
    }

    /**
     * @Route("/ajaxevents", name="_admin_events_ajax")
     */
    public function ajaxevents( PaginatorInterface $paginator, Request $request )
    {
        $this->init();
        $page = $request->query->get('page', 1) ;
        $userId = $request->query->get('userId');
        $sorts = $request->query->get('sorts');
        $deleted = $request->query->get('deleted');
        $fooRoute = $request->query->get('fooRoute');
        $fooId = $request->query->get('fooId');
        $max = 20;

        $eventsAll = $this->em->getRepository(Events::class)->findEvents([ 'userId'=>$userId, 'sorts'=>$sorts, 'deleted'=>$deleted] );

        $events = $paginator->paginate($eventsAll, $page, $max);

        return $this->render('admin/events/ajaxevents.html.twig', [
            'page' => $page,
            'user' => $this->user,
            'events' => $events ,
            'fooRoute' => $fooRoute ,
            'fooId' => $fooId
        ]);
    }

    /**
     * @Route("/addevent", name="_admin_add_event")
     */
    public function addevent(Request $request, FileUploader $fileUploader, Logger $logger, MessageHappyGenerator $messageGenerator)
    {
        $this->init();

        $event = new Events();

        $form = $this->createForm(EventEditType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();

            $status = $this->em->getRepository(EventStatus::class)->findOneBy(array('id' => 1));

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

            $logger->setLog( $this->user, 'event', $event->getId(), 'Dodano wydarzenie', $event->getTitle());

            $this->addFlash(
                'success',
                $messageGenerator->getMessage()
            );

            return $this->redirectToRoute('_admin_events');
        }

        return $this->render('admin/events/addevent.html.twig', [
            'user' => $this->user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{eventId}", name="_admin_edit_event")
     */
    public function edit( $eventId, Request $request, FileUploader $fileUploader, Logger $logger, MessageHappyGenerator $messageGenerator)
    {
        $this->init();

        $event = $this->em->getRepository(Events::class)->findOneBy(array('id' => $eventId));

        $form = $this->createForm(EventEditType::class, $event);

        $form->handleRequest($request);

        if ($form->isSubmitted()){
            if ($form->isValid()){

                $task = $form->getData();

                /** @var UploadedFile $brochureFile */
                $photo1File = $form['photo1']->getData();
                if ($photo1File) {
                    $photo1FileName = $fileUploader->upload($photo1File);
                    $event->setPhoto1Filename($photo1FileName);
                }

                $this->em->persist($event);
                $this->em->flush();

                $logger->setLog( $this->user, 'event', $event->getId(), 'Zaktualizowano wydarzenie', $event->getTitle());

                $this->addFlash(
                    'success',
                    $messageGenerator->getMessage()
                );

            } else {

                $this->addFlash(
                    'error',
                    $form->getErrors(true)
                );
            }
        }
        return $this->render('admin/events/editevent.html.twig', [
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/deleteevent/{eventId}/{fooRoute}/{fooId}/{confirm}", name="_admin_event_delete")
     */
    public function deleteevent($eventId, $fooRoute, $fooId, $confirm, Request $request, Logger $logger, MessageHappyGenerator $messageGenerator)
    {
        $this->init();

        $event = $this->em->getRepository(Events::class)->findOneBy(array('id' => $eventId));

        if($confirm == 1) {
            $event->setDeleted(1);
        } else {
            $event->setDeleted(0);
        }

        $this->em->persist($event);
        $this->em->flush();

        if($confirm == 1) {
            $logger->setLog( $this->user, 'event', $event->getId(), 'Skasowano wydarzenie', $event->getTitle());
        } else {
            $logger->setLog( $this->user, 'event', $event->getId(), 'Cofnięto skasowanie wydarzenie', $event->getTitle());
        }

        $this->addFlash(
            'success',
            $messageGenerator->getMessage()
        );

        if($fooRoute == 'departmentdetails'){
            return $this->redirectToRoute('_admin_department_details', ['department'=>$fooId] );
        }elseif($fooRoute == 'conservatordetails'){
            return $this->redirectToRoute('_admin_conservator_details', ['conservator'=>$fooId] );
        }elseif($fooRoute == 'adminevents'){
            return $this->redirectToRoute('_admin_events', ['conservator'=>$fooId] );
        }
    }

    /**
     * @Route("/removephoto/{eventId}", name="_admin_eventphoto_remove")
     */
    public function removeeventphoto( $eventId, Request $request, Logger $logger, MessageHappyGenerator $messageGenerator)
    {
        $this->init();

        $event = $this->em->getRepository(Events::class)->findOneBy(array('id' => $eventId));

        $event->setPhoto1Filename(null);

        $this->em->persist($event);
        $this->em->flush();

        $logger->setLog( $this->user, 'event', $event->getId(), 'Usunięto zdjęcie usterki', $event->getTitle());

        $this->addFlash(
            'success',
            $messageGenerator->getMessage()
        );

        return $this->redirectToRoute('_admin_edit_event', ['eventId'=>$eventId]);
    }
}