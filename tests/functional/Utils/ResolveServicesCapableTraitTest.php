<?php

namespace Dhii\Services\Tools\Test\Func\Utils;

use Dhii\Services\ServiceInterface;
use Dhii\Services\Tools\Utils\ResolveServicesCapableTrait;
use PHPUnit\Framework\TestCase;

class ResolveServicesCapableTraitTest extends TestCase
{
    /** @var ResolveServicesCapableTrait */
    protected $subject;

    public function setUp(): void
    {
        $this->subject = $this->getMockForTrait(ResolveServicesCapableTrait::class);
    }

    public function testResolve()
    {
        $services = [
            'a' => $a = $this->createMock(ServiceInterface::class),
            'b' => $b = $this->createMock(ServiceInterface::class),
            'c' => $c = $this->createMock(ServiceInterface::class),
            'd' => $d = $this->createMock(ServiceInterface::class),
        ];

        $expected = compact('b', 'c');
        $actual = $this->subject->resolveServices($services, ['b', 'c']);

        $this->assertSame($expected, $actual);
    }

    public function testResolveKeysDontExist()
    {
        $services = [
            'a' => $a = $this->createMock(ServiceInterface::class),
            'b' => $b = $this->createMock(ServiceInterface::class),
            'c' => $c = $this->createMock(ServiceInterface::class),
            'd' => $d = $this->createMock(ServiceInterface::class),
        ];

        $expected = compact('b');
        $actual = $this->subject->resolveServices($services, ['b', 'g', 'f']);

        $this->assertSame($expected, $actual);
    }
}
