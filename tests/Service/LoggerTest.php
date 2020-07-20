<?php

// tests/Factory/LoggerFactoryTest.php
namespace App\Factory;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\Logger;
use App\Factory\LoggerFactory;
use App\Entity\Users;

use PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    public function testCanLoggerSetLog()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);
        $user = $this->createMock(Users::class);

        $loggerFactory = new LoggerFactory();
        $logger = $loggerFactory->createLogger($entityManager);

        $actionName = "test";
        $actionValue = 0;
        $actionInfo = "This is test";
        $actionTitle = "This is test";

        $success = $logger->setLog( $user, $actionName, $actionValue, $actionInfo, $actionTitle );

        $this->assertTrue($success);
    }
}