<?php

namespace Dhii\Services\Tools\Test\Func\Analyzers;

use Dhii\Services\ServiceInterface;
use Dhii\Services\Tools\AnalyzerInterface;
use Dhii\Services\Tools\Analyzers\CircularDependencyAnalyzer;
use Dhii\Services\Tools\Issues\CircularDepIssue;
use PHPUnit\Framework\TestCase;

class CircularDependencyAnalyzerTest extends TestCase
{
    public function testCreate()
    {
        $subject = new CircularDependencyAnalyzer();

        $this->assertInstanceOf(AnalyzerInterface::class, $subject);
    }

    public function testNoProblems()
    {
        $factories = [
            'a' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['b']]),
            'b' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['c']]),
            'c' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => []]),
        ];
        $extensions = [
            'b' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => []]),
        ];

        $subject = new CircularDependencyAnalyzer();
        $issues = $subject->analyze($factories, $extensions);
        $issues = is_array($issues) ? $issues : iterator_to_array($issues, false);

        $this->assertCount(0, $issues);
    }

    public function testAnalyzeFactories()
    {
        $factories = [
            'a' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['b']]),
            'b' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['c']]),
            'c' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['a']]),
        ];
        $extensions = [
            'b' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => []]),
        ];

        $subject = new CircularDependencyAnalyzer();
        $issues = $subject->analyze($factories, $extensions);
        $issues = is_array($issues) ? $issues : iterator_to_array($issues, false);

        $this->assertCount(1, $issues);
        $this->assertInstanceOf(CircularDepIssue::class, $issues[0]);
        $this->assertEquals(['a', 'b', 'c'], $issues[0]->getDependencyChain());
        $this->assertEquals('a', $issues[0]->getService());
    }

    public function testAnalyzeExtensions()
    {
        $factories = [
            'a' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['b']]),
            'b' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['c']]),
            'c' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => []]),
        ];
        $extensions = [
            'c' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['a']]),
        ];

        $subject = new CircularDependencyAnalyzer();
        $issues = $subject->analyze($factories, $extensions);
        $issues = is_array($issues) ? $issues : iterator_to_array($issues, false);

        $this->assertCount(1, $issues);
        $this->assertInstanceOf(CircularDepIssue::class, $issues[0]);
        $this->assertEquals(['c', 'a', 'b'], $issues[0]->getDependencyChain());
        $this->assertEquals('c', $issues[0]->getService());
    }

    public function testAnalyzeMultipleChains()
    {
        $factories = [
            'a' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['b']]),
            'b' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['c']]),
            'c' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['a']]),
            'd' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => []]),
        ];
        $extensions = [
            'd' => $this->createConfiguredMock(ServiceInterface::class, ['getDependencies' => ['a']]),
        ];

        $subject = new CircularDependencyAnalyzer();
        $issues = $subject->analyze($factories, $extensions);
        $issues = is_array($issues) ? $issues : iterator_to_array($issues, false);

        $this->assertCount(2, $issues);
        $this->assertEquals(['a', 'b', 'c'], $issues[0]->getDependencyChain());
        $this->assertEquals(['d', 'a', 'b', 'c'], $issues[1]->getDependencyChain());
    }
}
