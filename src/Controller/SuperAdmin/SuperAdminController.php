<?php

// src/Controller/SuperAdminController.php
namespace App\Controller\SuperAdmin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use App\Service\FileUploader;
use App\Service\Logger;
use App\Entity\Users;
use App\Form\Type\AdminType;

/**
 * @Route("/superadmin")
 */
class SuperAdminController extends AbstractController
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
     * @Route("/home", name="_superadmin_home")
     */
    public function home()
    {
        $number = random_int(0, 100);

        return $this->render('superadmin/home.html.twig', [
            'number' => $number,
        ]);
    }

    /**
     * @Route("/edit", name="_superadmin_edit")
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

                $logger->setLog( $this->user, 'superadmin', $user->getId(), 'Edytowano superadmina', $user->getName());

                $this->addFlash(
                    'success',
                    'Dane zostały zaktualizowane!'
                );

                return $this->redirectToRoute('_superadmin_edit');

            } else {

                $this->addFlash(
                    'error',
                    $form->getErrors(true)
                );
            }
        }

        return $this->render('superadmin/edit.html.twig', [
            'superadmin' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/removeavatar", name="_superadmin_remove_avatar")
     */
    public function removeavatar(Request $request )
    {
        $this->init();

        $user = $this->em->getRepository(Users::class)->findOneBy(array('id' => $this->userId));

        $user->setAvatarFilename(null);

        $this->em->persist($user);
        $this->em->flush();

        $logger = new Logger($this->em);
        $logger->setLog( $this->user, 'superadmin', $user->getId(), 'Usunięto zdjęcie profilowe superadmin', $user->getName());

        $this->addFlash(
            'success',
            'Skasowano zdjęcie!'
        );

        return $this->redirectToRoute('_superadmin_edit' );
    }
}
