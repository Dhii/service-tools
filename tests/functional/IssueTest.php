<?php

namespace Me\Library\Test\Func;

use Dhii\Services\Tools\Issue;
use PHPUnit\Framework\TestCase;

class IssueTest extends TestCase
{
    public function testCreate()
    {
        $severity = Issue::SMELL;
        $message = 'A disturbance in the force';

        $subject = new Issue($severity, $message);

        $this->assertEquals($severity, $subject->getSeverity());
        $this->assertEquals($message, $subject->getMessage());
    }

    public function testSeverityValues()
    {
        $this->assertTrue(Issue::SMELL < Issue::WARNING);
        $this->assertTrue(Issue::SMELL < Issue::ERROR);
        $this->assertTrue(Issue::WARNING < Issue::ERROR);
    }
}
