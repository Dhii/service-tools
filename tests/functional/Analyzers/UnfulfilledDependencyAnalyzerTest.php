<?php

namespace Dhii\Services\Tools\Test\Func\Analyzers;

use Dhii\Services\ServiceInterface;
use Dhii\Services\Tools\AnalyzerInterface;
use Dhii\Services\Tools\Analyzers\UnfulfilledDependencyAnalyzer;
use Dhii\Services\Tools\Issue;
use Dhii\Services\Tools\Issues\DependencyIssue;
use PHPUnit\Framework\TestCase;

class UnfulfilledDependencyAnalyzerTest extends TestCase
{
    public function testCreate()
    {
        $subject = new UnfulfilledDependencyAnalyzer();

        $this->assertInstanceOf(AnalyzerInterface::class, $subject);
    }

    public function testAnalyzeFactories()
    {
        $factories = [
            'a' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['b']]),
            'b' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['c', 'd']]),
            'c' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => []]),
        ];
        $extensions = [
            'c' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['a']]),
        ];

        $subject = new UnfulfilledDependencyAnalyzer();
        $issues = $subject->analyze($factories, $extensions);
        $issues = is_array($issues) ? $issues : iterator_to_array($issues, false);

        $this->assertCount(1, $issues);
        $this->assertInstanceOf(DependencyIssue::class, $issues[0]);
        $this->assertEquals('b', $issues[0]->getService());
        $this->assertEquals('d', $issues[0]->getDependency());
        $this->assertEquals(Issue::WARNING, $issues[0]->getSeverity());
    }

    public function testAnalyzeExtensions()
    {
        $factories = [
            'a' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['b']]),
            'b' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['c']]),
            'c' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => []]),
        ];
        $extensions = [
            'c' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['d']]),
        ];

        $subject = new UnfulfilledDependencyAnalyzer();
        $issues = $subject->analyze($factories, $extensions);
        $issues = is_array($issues) ? $issues : iterator_to_array($issues, false);

        $this->assertCount(1, $issues);
        $this->assertInstanceOf(DependencyIssue::class, $issues[0]);
        $this->assertEquals('c', $issues[0]->getService());
        $this->assertEquals('d', $issues[0]->getDependency());
        $this->assertEquals(Issue::WARNING, $issues[0]->getSeverity());
    }

    public function testAnalyzeEverything()
    {
        $factories = [
            'a' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['b']]),
            'b' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['c', 'd']]),
            'c' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => []]),
        ];
        $extensions = [
            'c' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['e']]),
        ];

        $subject = new UnfulfilledDependencyAnalyzer();
        $issues = $subject->analyze($factories, $extensions);
        $issues = is_array($issues) ? $issues : iterator_to_array($issues, false);

        $this->assertCount(2, $issues);
    }
}
