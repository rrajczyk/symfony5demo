<?php

// tests/Factory/LoggerFactoryTest.php
namespace App\Factory;

use App\Service\MessageBusinessGenerator;
use App\Factory\MessageGeneratorFactory;

use PHPUnit\Framework\TestCase;

class MessageBusinessGeneratorTest extends TestCase
{
    public function testCanGetBusinessMessage()
    {
        $messageGenerator = new MessageGeneratorFactory();
        $messageBusinessGenerator = $messageGenerator->createMessageHappy();

        $message = $messageBusinessGenerator->getMessage();

        $this->assertInternalType('string', $message);
    }
}