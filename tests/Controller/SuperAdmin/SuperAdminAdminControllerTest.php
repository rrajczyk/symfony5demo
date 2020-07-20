<?php

// tests/Controller/SuperAdmin/SuperAdminAdminControllerTest.php
namespace App\Controller\SuperAdmin;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Users;
use App\Entity\UserTypes;
use PHPUnit\Framework\TestCase;

class SuperAdminAdminControllerTest extends TestCase
{
    public function testCanCreateConservator()
    {
        try{
            $success = true;
            $entityManager = $this->createMock(EntityManagerInterface::class);
            $user = $this->createMock(Users::class);
            $type = $this->createMock(UserTypes::class);

            $user->setUsername("test");
            $user->setRoles(["ROLE_ADMIN"]);
            $user->setUserType($type);
            $user->setPassword("hash");
            $user->setName("test");
            $user->setAddress("test");
            $user->setDateCreated(new \DateTime('now'));
            $user->setDeleted(0);
            $user->setEmails("test@gmail.com");
            $user->setPhone("777");

            $entityManager->persist($user);
            $entityManager->flush();

        } catch (Exception $e) {
            $success = false;
        }

        $this->assertTrue($success);
    }
}
