<?php

// tests/BasicTest.php
namespace App\Tests\Controller;

use PHPUnit\Framework\TestCase;

class BasicTest extends TestCase
{
    public function testAddString()
    {
        $message = "A" . "B";

        $this->assertInternalType('string', $message);
    }

    public function testAddFloat()
    {
        $message = 12 + "12.6";

        $this->assertInternalType('float', $message);
    }
}