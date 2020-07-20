<?php

// src/Factory/MessageGeneratorFactory.php
namespace App\Factory;
use App\Service\MessageHappyGenerator;
use App\Service\MessageBusinessGenerator;
use App\Interfaces\MessageGeneratorFactoryInterface;

class MessageGeneratorFactory implements MessageGeneratorFactoryInterface
{
    public static function createMessageHappy()
    {
        $messageGenerator = new MessageHappyGenerator();
        $messageGenerator->setMessages();

        return $messageGenerator;
    }

    public static function createMessageBusiness()
    {
        $messageGenerator = new MessageBusinessGenerator();
        $messageGenerator->setMessages();

        return $messageGenerator;
    }
}