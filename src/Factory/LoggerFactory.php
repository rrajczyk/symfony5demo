<?php

// src/Factory/LoggerFactory.php
namespace App\Factory;

use Doctrine\ORM\EntityManagerInterface;
use App\Service\Logger;
use App\Interfaces\LoggerFactoryInterface;

class LoggerFactory implements LoggerFactoryInterface
{
    public static function createLogger( EntityManagerInterface $entityManager )
    {
        $logger = new Logger( $entityManager );

        return $logger;
    }
}