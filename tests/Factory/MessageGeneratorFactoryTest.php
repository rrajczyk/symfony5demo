<?php

// tests/Factory/MessageGeneratorFactoryTest.php
namespace App\Factory;

use App\Service\MessageHappyGenerator;
use App\Service\MessageBusinessGenerator;
use App\Factory\MessageGeneratorFactory;

use PHPUnit\Framework\TestCase;

class MessageGeneratorFactoryTest extends TestCase
{
    public function testCanCreateMessageHappyGenerator()
    {
        $messageGenerator = new MessageGeneratorFactory();
        $messageHappyGenerator = $messageGenerator->createMessageHappy();

        $this->assertInstanceOf(MessageHappyGenerator::class, $messageHappyGenerator);
    }

    public function testCanCreateFileLogging()
    {
        $messageGenerator = new MessageGeneratorFactory();
        $messageBusinessGenerator = $messageGenerator->createMessageBusiness();

        $this->assertInstanceOf(MessageBusinessGenerator::class, $messageBusinessGenerator);
    }
}