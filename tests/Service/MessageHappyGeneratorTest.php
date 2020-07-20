<?php

// tests/Factory/LoggerFactoryTest.php
namespace App\Factory;

use App\Service\MessageHappyGenerator;
use App\Factory\MessageGeneratorFactory;

use PHPUnit\Framework\TestCase;

class MessageHappyGeneratorTest extends TestCase
{
    public function testCanGetHappyMessage()
    {
        $messageGenerator = new MessageGeneratorFactory();
        $messageHappyGenerator = $messageGenerator->createMessageHappy();

        $message = $messageHappyGenerator->getMessage();

        $this->assertInternalType('string', $message);
    }
}