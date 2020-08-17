<?php

// src/Controller/AdminController.php
namespace App\Controller\SuperAdmin;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Knp\Component\Pager\PaginatorInterface;
use App\Service\FileUploader;
use App\Service\Logger;
use App\Entity\Users;
use App\Entity\Events;
use App\Entity\UserTypes;
use App\Form\Type\ConservatorType;

/**
 * @Route("/superadmin/conservators")
 */
class SuperAdminConservatorController extends AbstractController
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
     * @Route("/", name="_superadmin_conservators")
     */
    public function conservators()
    {
        $this->init();
        $dateStart = date("Y-m-d", strtotime("first day of previous month"));
        $dateEnd  = date('Y-m-d');

        return $this->render('superadmin/conservators/conservators.html.twig', [
            'user' => $this->user ,
            'dateStart' => $dateStart,
            'dateEnd' => $dateEnd
        ]);
    }

    /**
     * @Route("/ajaxconservators", name="_superadmin_conservators_ajax")
     */
    public function ajaxconservators( PaginatorInterface $paginator, Request $request )
    {
        $this->init();

        $page = $request->query->get('page', 1) ;
        $sorts = $request->query->get('sorts');
        $dateStart = $request->query->get('dateStart');
        $dateEnd = $request->query->get('dateEnd');
        $max = 20;

        $conservatorsAll = $this->em->getRepository(Users::class)->findUsers(['sorts' => $sorts, 'dateStart'=>$dateStart, 'dateEnd'=>$dateEnd, 'user_type' => 3, 'deleted' => 0], ['name'=>'ASC'] );

        $conservators = $paginator->paginate($conservatorsAll, $page, $max);

        return $this->render('superadmin/conservators/ajaxconservators.html.twig', [
            'page' => $page,
            'user' => $this->user,
            'conservators' => $conservators
        ]);
    }

    /**
     * @Route("/conservatordetails/{conservator}", name="_superadmin_conservator_details")
     */
    public function conservatordetails($conservator)
    {
        $this->init();

        $user = $this->em->getRepository(Users::class)->findOneBy(array('id' => $conservator));

        return $this->render('superadmin/conservators/conservatordetails.html.twig', [
            'conservator' => $user
        ]);
    }

    /**
     * @Route("/ajaxconservatorevents", name="_superadmin_conservatorevents_ajax")
     */
    public function ajaxconservatorevents( PaginatorInterface $paginator, Request $request )
    {
        $this->init();
        $page = $request->query->get('page', 1) ;
        $userId = $request->query->get('userId');
        $sorts = $request->query->get('sorts');
        $deleted = $request->query->get('deleted');
        $fooRoute = $request->query->get('fooRoute');
        $fooId = $request->query->get('fooId');
        $max = 20;

        $eventsAll = $this->em->getRepository(Events::class)->findEvents(['userId'=>$userId, 'sorts'=>$sorts, 'deleted'=>$deleted] );

        $events = $paginator->paginate($eventsAll, $page, $max);

        return $this->render('superadmin/conservators/ajaxconservatorevents.html.twig', [
            'page' => $page,
            'user' => $this->user,
            'events' => $events ,
            'fooRoute' => $fooRoute ,
            'fooId' => $fooId
        ]);
    }

    /**
     * @Route("/addconservator", name="_superadmin_conservator_add")
     */
    public function addconservator(Request $request, FileUploader $fileUploader, UserPasswordEncoderInterface $encoder, Logger $logger)
    {
        $this->init();

        $user = new Users();

        $form = $this->createForm(ConservatorType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {

                $task = $form->getData();

                $type = $this->em->getRepository(UserTypes::class)->findOneBy(array('id' => 3));

                $user->setUserType($type);
                $user->setRoles(["ROLE_CONSERVATOR"]);
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

                $logger->setLog( $this->user, 'conservator', $user->getId(), 'Dodano konserwatora', $user->getName());

                $this->addFlash(
                    'success',
                    'Dodano konserwatora!'
                );

                return $this->redirectToRoute('_superadmin_conservators');

            } else {

                $this->addFlash(
                    'error',
                    $form->getErrors(true)
                );
            }
        }

        return $this->render('superadmin/conservators/addconservator.html.twig', [
            'user' => $this->user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/editconservator/{conservator}", name="_superadmin_conservator_edit")
     */
    public function editconservator($conservator, Request $request, FileUploader $fileUploader, UserPasswordEncoderInterface $encoder, Logger $logger)
    {
        $this->init();

        $user = $this->em->getRepository(Users::class)->findOneBy(array('id' => $conservator));

        $form = $this->createForm(ConservatorType::class, $user);

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

                $logger->setLog( $this->user, 'conservator', $user->getId(), 'Edytowano konserwatora', $user->getName());

                $this->addFlash(
                    'success',
                    'Dane zostały zaktualizowane!'
                );

                return $this->redirectToRoute('_superadmin_conservators');

            } else {

                $this->addFlash(
                    'error',
                    $form->getErrors(true)
                );
            }
        }

        return $this->render('superadmin/conservators/editconservator.html.twig', [
            'conservator' => $user,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/removeavatar/{conservator}", name="_superadmin_conservator_remove_avatar")
     */
    public function removeavatar( $conservator, Logger $logger)
    {
        $this->init();

        $user = $this->em->getRepository(Users::class)->findOneBy(array('id' => $conservator));

        $user->setAvatarFilename(null);

        $this->em->persist($user);
        $this->em->flush();

        $logger->setLog( $this->user, 'conservator', $user->getId(), 'Usunięto zdjęcie profilowe konserwatora', $user->getName());

        $this->addFlash(
            'success',
            'Skasowano zdjęcie!'
        );

        return $this->redirectToRoute('_superadmin_conservator_edit', ['conservator'=>$conservator] );
    }

    /**
     * @Route("/delete/{conservator}", name="_superadmin_conservator_delete")
     */
    public function deleteconservator($conservator, Logger $logger)
    {
        $this->init();

        $user = $this->em->getRepository(Users::class)->findOneBy(array('id' => $conservator));
        $user->setDeleted(1);

        $this->em->persist($user);
        $this->em->flush();

        $logger->setLog( $this->user, 'conservator', $user->getId(), 'Skasowano konserwatora', $user->getName());

        $this->addFlash(
            'success',
            'Usunąłeś konserwatora !'
        );

        return $this->redirectToRoute('_superadmin_conservators' );
    }
}
