<?php

// tests/Factory/LoggerFactoryTest.php
namespace App\Factory;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\Logger;
use App\Factory\LoggerFactory;

use PHPUnit\Framework\TestCase;

class LoggerFactoryTest extends TestCase
{
    public function testCanCreateLogger()
    {
        $entityManager = $this->createMock(EntityManagerInterface::class);

        $loggerFactory = new LoggerFactory();
        $logger = $loggerFactory->createLogger($entityManager);

        $this->assertInstanceOf(Logger::class, $logger);
    }
}