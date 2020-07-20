<?php

// src/Service/MessageHappyGenerator.php
namespace App\Service;
use App\Interfaces\MessageGeneratorFactory;

class MessageHappyGenerator implements MessageGeneratorFactory
{
    private $messages;

    public function setMessages()
    {
        $this->messages = [
            'Zrobiłeś to! Jesteś niesamowity!',
            'To była jedna z najfajniejszych aktualizacji, jakie widziałem przez cały dzień!',
            'Świetna robota! Tak trzymaj!',
        ];
    }

    public function setMessages2()
    {
        $this->messages = [
            'Niedowiary! Udało się!',
            'Gratulacje! O twojej operacji będą pisać legendy',
            'Tak trzymaj! Wszystko poszło dobrze! Nie poddawaj się!',
        ];
    }

    public function getMessage()
    {
        $index = array_rand($this->messages);

        return $this->messages[$index];
    }
}