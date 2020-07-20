<?php

// src/Interfaces/LoggerFactoryInterface.php
namespace App\Interfaces;
use Doctrine\ORM\EntityManagerInterface;

interface LoggerFactoryInterface
{
    public static function createLogger(EntityManagerInterface $entityManager);
}