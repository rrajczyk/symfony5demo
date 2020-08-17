<?php

// src/Controller/SuperAdminAdminController.php
namespace App\Controller\SuperAdmin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\FileUploader;
use App\Service\Logger;
use App\Service\MessageHappyGenerator;
use App\Service\MessageBusinessGenerator;
use App\Entity\Users;
use App\Entity\UserTypes;
use App\Form\Type\AdminType;

/**
 * @Route("/superadmin/admins")
 */
class SuperAdminAdminController extends AbstractController
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
     * @Route("/", name="_superadmin_admins")
     */
    public function admins()
    {
        $this->init();

        return $this->render('superadmin/admins/admins.html.twig', [
            'user' => $this->user,
        ]);
    }

    /**
     * @Route("/ajaxadmins", name="_superadmin_admins_ajax")
     */
    public function ajaxadmins( PaginatorInterface $paginator, Request $request )
    {
        $this->init();

        $page = $request->query->get('page', 1);
        $max = 20;

        $adminsAll = $this->em->getRepository(Users::class)->findUsers([ 'user_type' => 1, 'deleted' => 0], ['name'=>'ASC'] );

        $admins = $paginator->paginate($adminsAll, $page, $max);

        return $this->render('superadmin/admins/ajaxadmins.html.twig', [
            'page' => $page,
            'user' => $this->user,
            'admins' => $admins
        ]);
    }

    /**
     * @Route("/addadmin", name="_superadmin_admin_add")
     */
    public function addadmin(Request $request, FileUploader $fileUploader, UserPasswordEncoderInterface $encoder, Logger $logger, MessageBusinessGenerator $messageGenerator)
    {
        $this->init();

        $user = new Users();

        $form = $this->createForm(AdminType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $task = $form->getData();

                $type = $this->em->getRepository(UserTypes::class)->findOneBy(array('id' => 1));

                $user->setUserType($type);
                $user->setRoles(["ROLE_ADMIN"]);
                $user->setDeleted(0);
                $user->setDateCreated(new \DateTime('now'));

                $formPass = $form->get('pass')->getData();
                $encodedPassword = $encoder->encodePassword($user, $formPass );
                $user->setPassword($encodedPassword);

                /** @var UploadedFile $brochureFile */
                $avatarFile = $form['avatar']->getData();
                if ($avatarFile) {
                    $avatarFileName = $fileUploader->upload($avatarFile);
                    $user->setAvatarFilename($avatarFileName);
                }

                $this->em->persist($user);
                $this->em->flush();

                $logger->setLog( $this->user, 'admin', $user->getId(), 'Dodano admina', $user->getName());

                $this->addFlash(
                    'success',
                    $messageGenerator->getMessage()
                );

                return $this->redirectToRoute('_superadmin_admins');

            } else {

                $this->addFlash(
                    'error',
                    $form->getErrors(true)
                );
            }
        }

        return $this->render('superadmin/admins/addadmin.html.twig', [
            'user' => $this->user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/editadmin/{admin}", name="_superadmin_admin_edit")
     */
    public function editadmin($admin, Request $request, FileUploader $fileUploader, UserPasswordEncoderInterface $encoder, Logger $logger, MessageHappyGenerator $messageGenerator)
    {
        $this->init();

        $user = $this->em->getRepository(Users::class)->findOneBy(array('id' => $admin));

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
                    $messageGenerator->getMessage()
                );

                return $this->redirectToRoute('_superadmin_admins');

            } else {

                $this->addFlash(
                    'error',
                    $form->getErrors(true)
                );
            }
        }

        return $this->render('superadmin/admins/editadmin.html.twig', [
            'admin' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/removeavatar/{admin}", name="_superadmin_admin_remove_avatar")
     */
    public function removeavatar( $admin, Logger $logger)
    {
        $this->init();

        $user = $this->em->getRepository(Users::class)->findOneBy(array('id' => $admin));

        $user->setAvatarFilename(null);

        $this->em->persist($user);
        $this->em->flush();

        $logger->setLog( $this->user, 'admin', $user->getId(), 'Usunięto zdjęcie profilowe admina', $user->getName());

        $this->addFlash(
            'success',
            'Skasowano zdjęcie!'
        );

        return $this->redirectToRoute('_superadmin_admin_edit', ['admin'=>$admin] );
    }

    /**
     * @Route("/delete/{admin}", name="_superadmin_admin_delete")
     */
    public function deleteadmin($admin, Logger $logger)
    {
        $this->init();

        $user = $this->em->getRepository(Users::class)->findOneBy(array('id' => $admin));
        $user->setDeleted(1);

        $this->em->persist($user);
        $this->em->flush();

        $logger->setLog( $this->user, 'admin', $user->getId(), 'Skasowano admina', $user->getName());

        $this->addFlash(
            'success',
            'Usunąłeś konserwatora !'
        );

        return $this->redirectToRoute('_superadmin_admins' );
    }
}
