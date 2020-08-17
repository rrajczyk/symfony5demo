<?php

// src/Controller/AdminController.php
namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploader;
use App\Service\MessageBusinessGenerator;
use App\Service\Logger;
use App\Form\Type\UserType;
use App\Entity\Users;

/**
 * @Route("/user")
 */
class UserController extends AbstractController
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
     * @Route("/edit", name="_user_edit")
     */
    public function edit( Request $request, FileUploader $fileUploader, Logger $logger, MessageBusinessGenerator $messageGenerator)
    {
        $this->init();

        $user = $this->em->getRepository(Users::class)->findOneBy(array('id' => $this->userId));

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $task = $form->getData();

            /** @var UploadedFile $brochureFile */
            $avatarFile = $form['avatar']->getData();
            if ($avatarFile) {
                $avatarFileName = $fileUploader->upload($avatarFile);
                $user->setAvatarFilename($avatarFileName);
            }

            $this->em->persist($user);
            $this->em->flush();

            if ($user->getUserType()->getId() == 3){
                $logger->setLog( $this->user, 'conservator', $user->getId(), 'Zaktualizowano zdjęcie profilowe', $user->getName());
            }

            $this->addFlash(
                'success',
                $messageGenerator->getMessage()
            );

            //return $this->redirectToRoute('_user_edit');
        }

        return $this->render('user/edit.html.twig', [
            'user' => $this->user,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/removeavatar", name="_user_remove_avatar")
     */
    public function removeavatar(Logger $logger, MessageBusinessGenerator $messageGenerator)
    {
        $this->init();

        $user = $this->em->getRepository(Users::class)->findOneBy(array('id' => $this->userId));

        $user->setAvatarFilename(null);

        $this->em->persist($user);
        $this->em->flush();

        if($user->getUserTypeId() == 2){
            $logger->setLog( $this->user, 'department', $user->getId(), 'Usunięto zdjęcie profilowe', $user->getName());
        } elseif ($user->getUserTypeId() == 3){
            $logger->setLog( $this->user, 'conservator', $user->getId(), 'Usunięto zdjęcie profilowe', $user->getName());
        }

        $this->addFlash(
            'success',
            $messageGenerator->getMessage()
        );

        return $this->redirectToRoute('_user_edit');
    }
}
