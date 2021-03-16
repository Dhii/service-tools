<?php

namespace Dhii\Services\Tools\Test\Func\Utils;

use Dhii\Services\ServiceInterface;
use Dhii\Services\Tools\Utils\GetServiceDepsCapableTrait;
use PHPUnit\Framework\TestCase;

class GetServiceDepsCapableTraitTest extends TestCase
{
    /** @var GetServiceDepsCapableTrait */
    protected $subject;

    public function setUp(): void
    {
        $this->subject = $this->getMockForTrait(GetServiceDepsCapableTrait::class);
    }

    public function testGetDepsFromCallable()
    {
        $service = function () { };
        $actual = $this->subject->getServiceDeps($service);

        $this->assertEmpty($actual);
    }

    public function testGetDepsFromServiceInterface()
    {
        $expected = ['Luke', 'Leia', 'Lytvynenko'];
        $service = $this->createConfiguredMock(ServiceInterface::class, [
            'getDependencies' => $expected,
        ]);

        $actual = $this->subject->getServiceDeps($service);

        $this->assertEquals($expected, $actual);
    }
}
