<?php

namespace Dhii\Services\Tools\Test\Func\Issues;

use Dhii\Services\Tools\Issue;
use Dhii\Services\Tools\Issues\DependencyIssue;
use PHPUnit\Framework\TestCase;

class DependencyIssueTest extends TestCase
{
    public function testCreate()
    {
        $severity = Issue::WARNING;
        $message = 'If you do that again I will kill you';
        $service = 'kick_in_the_nuts';
        $dependency = 'nuts';

        $subject = new DependencyIssue($severity, $message, $service, $dependency);

        $this->assertEquals($severity, $subject->getSeverity());
        $this->assertEquals($message, $subject->getMessage());
        $this->assertEquals($service, $subject->getService());
        $this->assertEquals($dependency, $subject->getDependency());
    }
}
