<?php

namespace Dhii\Services\Tools\Test\Func\Issues;

use Dhii\Services\Tools\Issue;
use Dhii\Services\Tools\Issues\CircularDepIssue;
use PHPUnit\Framework\TestCase;
use UnexpectedValueException;

class CircularDepIssueTest extends TestCase
{
    public function testCreate()
    {
        $depChain = ['foo', 'bar'];
        $subject = new CircularDepIssue($depChain);

        $this->assertEquals(Issue::ERROR, $subject->getSeverity());
        $this->assertEquals($depChain, $subject->getDependencyChain());
    }

    public function testCreateWithEmptyChain()
    {
        $this->expectException(UnexpectedValueException::class);

        new CircularDepIssue([]);
    }

    public function testMessageShortChain()
    {
        $depChain = ['chicken', 'egg'];

        $subject = new CircularDepIssue($depChain);
        $expect = 'chicken -> egg -> chicken';

        $this->assertStringContainsString($expect, $subject->getMessage());
        $this->assertEquals($depChain, $subject->getDependencyChain());
        $this->assertEquals('chicken', $subject->getService());
    }

    public function testMessageOneDepChain()
    {
        $depChain = ['love'];

        $subject = new CircularDepIssue($depChain);
        $expect = 'love -> love';

        $this->assertStringContainsString($expect, $subject->getMessage());
        $this->assertEquals($depChain, $subject->getDependencyChain());
        $this->assertEquals('love', $subject->getService());
    }

    public function testMessageLongChain()
    {
        $depChain = ['fear', 'anger', 'hate', 'suffering', 'dark side'];

        $subject = new CircularDepIssue($depChain);
        $expect = 'fear -> anger -> hate -> suffering -> dark side';

        $this->assertStringContainsString($expect, $subject->getMessage());
        $this->assertEquals($depChain, $subject->getDependencyChain());
        $this->assertEquals('fear', $subject->getService());
    }
}
