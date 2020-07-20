<?php

// src/Service/MessageGenerator.php
namespace App\Service;

class MessageGenerator
{
    private $messages;

    public function setHappyMessage()
    {
        $this->messages = [
            'Zrobiłeś to! Jesteś niesamowity!',
            'To była jedna z najfajniejszych aktualizacji, jakie widziałem przez cały dzień!',
            'Świetna robota! Tak trzymaj!',
        ];
    }

    public function setBusinessMessage()
    {
        $this->messages = [
            'Operacja zakończyła się sukcesem!',
            'Wszystko poszło ok!',
            'Zmiany zostały zatwierdzone!',
        ];
    }

    public function getMessage()
    {
        $index = array_rand($this->messages);

        return $this->messages[$index];
    }
}