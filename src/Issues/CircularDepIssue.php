<?php

namespace Dhii\Services\Tools\Issues;

use UnexpectedValueException;

class CircularDepIssue extends ServiceIssue
{
    /** @var string[] */
    protected $depChain;

    /**
     * Constructor.
     *
     * @param string[] $depChain
     */
    public function __construct(array $depChain)
    {
        if (count($depChain) === 0) {
            throw new UnexpectedValueException('Dependency chain cannot be empty');
        }

        $service = reset($depChain);
        $message = 'Circular dependency: ' . implode(' -> ', $depChain) . ' -> ' . $service;

        parent::__construct(static::ERROR, $message, $service);
        $this->depChain = $depChain;
    }

    /**
     * @return string[]
     */
    public function getDependencyChain(): array
    {
        return $this->depChain;
    }
}
