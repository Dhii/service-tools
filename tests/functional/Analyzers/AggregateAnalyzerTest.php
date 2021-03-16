<?php

namespace Dhii\Services\Tools\Test\Func\Analyzers;

use Dhii\Services\Tools\AnalyzerInterface;
use Dhii\Services\Tools\Analyzers\AggregateAnalyzer;
use Dhii\Services\Tools\Issue;
use PHPUnit\Framework\TestCase;

class AggregateAnalyzerTest extends TestCase
{
    public function testCreate()
    {
        $subject = new AggregateAnalyzer([]);

        $this->assertInstanceOf(AnalyzerInterface::class, $subject);
    }

    public function testAnalyze()
    {
        $issues1 = [
            new Issue(Issue::WARNING, 'Oh no'),
            new Issue(Issue::SMELL, 'Your code smells bad'),
        ];
        $issues2 = [
            new Issue(Issue::ERROR, 'This needs fixing'),
            new Issue(Issue::WARNING, 'This might end badly'),
        ];

        $factories = ['a' => function () { }, 'b' => function () { }];
        $extensions = ['a' => function () { }, 'b' => function () { }];

        $analyzer1 = $this->createMock(AnalyzerInterface::class);
        $analyzer2 = $this->createMock(AnalyzerInterface::class);

        $analyzer1->expects($this->once())
                  ->method('analyze')
                  ->with($factories, $extensions)
                  ->willReturn($issues1);
        $analyzer2->expects($this->once())
                  ->method('analyze')
                  ->with($factories, $extensions)
                  ->willReturn($issues2);

        $subject = new AggregateAnalyzer([$analyzer1, $analyzer2]);

        $expected = array_merge($issues1, $issues2);
        $actual = $subject->analyze($factories, $extensions);
        $actual = is_array($actual) ? $actual : iterator_to_array($actual, false);

        $this->assertEquals($expected, $actual);
    }
}
