<?php

// src/Controller/AdminController.php
namespace App\Controller\Admin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploader;
use App\Service\Logger;
use App\Entity\Users;
use App\Form\Type\AdminType;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
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
     * @Route("/home", name="_admin_home")
     */
    public function home()
    {
        $number = random_int(0, 100);

        return $this->render('admin/home.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/edit", name="_admin_edit")
     */
    public function edit(Request $request, FileUploader $fileUploader, UserPasswordEncoderInterface $encoder, Logger $logger)
    {
        $this->init();

        $user = $this->em->getRepository(Users::class)->findOneBy(array('id' => $this->userId));

        $form = $this->createForm(AdminType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $task = $form->getData();

                $formPass = $form->get('pass')->getData();

                if($formPass){
                    $encodedPassword = $encoder->encodePassword($user, $formPass );
                    $user->setPassword($encodedPassword);
                }

                /** @var UploadedFile $brochureFile */
                $avatarFile = $form['avatar']->getData();
                if ($avatarFile) {
                    $avatarFileName = $fileUploader->upload($avatarFile);
                    $user->setAvatarFilename($avatarFileName);
                }

                $this->em->persist($user);
                $this->em->flush();

                $logger->setLog( $this->user, 'admin', $user->getId(), 'Edytowano admina', $user->getName());

                $this->addFlash(
                    'success',
                    'Dane zostały zaktualizowane!'
                );

                return $this->redirectToRoute('_admin_edit');

            } else {

                $this->addFlash(
                    'error',
                    $form->getErrors(true)
                );
            }
        }

        return $this->render('admin/edit.html.twig', [
            'admin' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/removeavatar", name="_admin_remove_avatar")
     */
    public function removeavatar()
    {
        $this->init();

        $user = $this->em->getRepository(Users::class)->findOneBy(array('id' => $this->userId));

        $user->setAvatarFilename(null);

        $this->em->persist($user);
        $this->em->flush();

        $logger = new Logger($this->em);
        $logger->setLog( $this->user, 'admin', $user->getId(), 'Usunięto zdjęcie profilowe admina', $user->getName());

        $this->addFlash(
            'success',
            'Skasowano zdjęcie!'
        );

        return $this->redirectToRoute('_admin_edit' );
    }
}
