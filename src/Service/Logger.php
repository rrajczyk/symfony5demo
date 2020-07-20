<?php

// src/Service/Logger.php
namespace App\Service;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Logs;
use App\Entity\Users;

class Logger
{
    private $entityManager;
    private $user;
    private $userId;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function setLog( Users $user, string $actionName, int $actionValue, string $actionInfo, string $actionTitle) : bool
    {
        try{
            $log = new Logs();

            $log->setUser($user);
            $log->setActionName($actionName);
            $log->setActionValue($actionValue);
            $log->setActionInfo($actionInfo);
            $log->setActionTitle($actionTitle);
            $log->setDateCreated(new \DateTime('now'));

            $this->entityManager->persist($log);
            $this->entityManager->flush();

            return true;

        } catch (Exception $e) {
            return false;
        }
    }
}