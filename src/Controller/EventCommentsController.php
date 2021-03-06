<?php

// src/Controller/AdminController.php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploader;
use App\Service\Logger;
use App\Form\Type\EventCommentType;
use App\Entity\Events;
use App\Entity\EventComments;

/**
 * @Route("/eventcomments")
 */
class EventCommentsController extends AbstractController
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
     * @Route("/addcomment/{eventId}", name="_add_comment")
     */
    public function addcomment($eventId, Request $request, FileUploader $fileUploader, Logger $logger)
    {
        $this->init();

        $event = $this->em->getRepository(Events::class)->findOneBy(array('id' => $eventId));
        $eventComment = new EventComments();

        $form = $this->createForm(EventCommentType::class, $eventComment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();

            $eventComment->setUser($this->user);
            $eventComment->setEvent($event);
            $eventComment->setDeleted(false);
			$eventComment->setDateCreated(new \DateTime('now'));

            /** @var UploadedFile $brochureFile */
            $photo1File = $form['photo1']->getData();
            if ($photo1File) {
                $photo1FileName = $fileUploader->upload($photo1File);
                $eventComment->setPhoto1Filename($photo1FileName);
            }

            $event->setLastCommentText($form['description']->getData());
            $event->setLastCommentUser($this->user);
            $event->setLastCommentDate(new \DateTime('now'));

            $this->em->persist($eventComment);
            $this->em->persist($event);
            $this->em->flush();

            $logger->setLog( $this->user, 'event', $event->getId(), 'Dodano komentarz - '.$form['description']->getData(), $event->getTitle());

            return $this->redirectToRoute('_departament_home');
        }

        return $this->render('eventcomments/addcomment.html.twig', [
            'user' => $this->user,
            'event' => $event,
            'form' => $form->createView(),
        ]);
    }
}