<?php

namespace Dhii\Services\Tools\Test\Func\Issues;

use Dhii\Services\Tools\Issue;
use Dhii\Services\Tools\Issues\ServiceIssue;
use PHPUnit\Framework\TestCase;

class ServiceIssueTest extends TestCase
{
    public function testCreate()
    {
        $severity = Issue::ERROR;
        $message = 'He\'s dead, Jim';
        $service = 'hitman';

        $subject = new ServiceIssue($severity, $message, $service);

        $this->assertEquals($severity, $subject->getSeverity());
        $this->assertEquals($message, $subject->getMessage());
        $this->assertEquals($service, $subject->getService());
    }
}
