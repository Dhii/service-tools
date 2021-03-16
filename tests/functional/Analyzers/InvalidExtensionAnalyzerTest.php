<?php

namespace Dhii\Services\Tools\Test\Func\Analyzers;

use Dhii\Services\ServiceInterface;
use Dhii\Services\Tools\AnalyzerInterface;
use Dhii\Services\Tools\Analyzers\InvalidExtensionAnalyzer;
use Dhii\Services\Tools\Issue;
use Dhii\Services\Tools\Issues\ServiceIssue;
use PHPUnit\Framework\TestCase;

class InvalidExtensionAnalyzerTest extends TestCase
{
    public function testCreate()
    {
        $subject = new InvalidExtensionAnalyzer();

        $this->assertInstanceOf(AnalyzerInterface::class, $subject);
    }

    public function testAnalyze()
    {
        $factories = [
            'a' => $this->createMock(ServiceInterface::class),
            'b' => $this->createMock(ServiceInterface::class),
        ];
        $extensions = [
            'c' => $this->createMock(ServiceInterface::class),
        ];

        $subject = new InvalidExtensionAnalyzer();
        $issues = $subject->analyze($factories, $extensions);
        $issues = is_array($issues) ? $issues : iterator_to_array($issues, false);

        $this->assertCount(1, $issues);
        $this->assertInstanceOf(ServiceIssue::class, $issues[0]);
        $this->assertEquals('c', $issues[0]->getService());
        $this->assertEquals(Issue::WARNING, $issues[0]->getSeverity());
    }

    public function testAnalyzeNoProblems()
    {
        $factories = [
            'a' => $this->createMock(ServiceInterface::class),
            'b' => $this->createMock(ServiceInterface::class),
        ];
        $extensions = [
            'b' => $this->createMock(ServiceInterface::class),
        ];

        $subject = new InvalidExtensionAnalyzer();
        $issues = $subject->analyze($factories, $extensions);
        $issues = is_array($issues) ? $issues : iterator_to_array($issues, false);

        $this->assertCount(0, $issues);
    }
}
