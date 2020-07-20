<?php

// src/Interfaces/MessageGeneratorFactoryInterface.php
namespace App\Interfaces;

interface MessageGeneratorFactoryInterface
{
    public static function createMessageHappy();
    public static function createMessageBusiness();
}