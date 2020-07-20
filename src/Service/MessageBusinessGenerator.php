<?php

// src/Service/MessageBusinessGenerator.php
namespace App\Service;
use App\Interfaces\MessageGeneratorFactory;

class MessageBusinessGenerator implements MessageGeneratorFactory
{
    public function setMessages()
    {
        $this->messages = [
            'Operacja zakończyła się sukcesem!',
            'Wszystko poszło ok!',
            'Zmiany zostały zatwierdzone!',
        ];
    }

    public function setMessages2()
    {
        $this->messages = [
            '1Operacja zakończyła się sukcesem!',
            '1Wszystko poszło ok!',
            '1Zmiany zostały zatwierdzone!',
        ];
    }

    public function getMessage()
    {
        $index = array_rand($this->messages);

        return $this->messages[$index];
    }
}