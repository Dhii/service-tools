<?php

declare(strict_types=1);

namespace Dhii\Services\Tools\Issues;

use UnexpectedValueException;

/**
 * An circular dependency issue.
 */
class CircularDepIssue extends ServiceIssue
{
    /** @var string[] */
    protected $depChain;

    /**
     * Constructor.
     *
     * @param string[] $depChain The list of dependency keys in order of requirement (dependents first).
     *
     * @throws UnexpectedValueException If the given dependency chain is empty.
     */
    public function __construct(array $depChain)
    {
        if (count($depChain) === 0) {
            throw new UnexpectedValueException('Dependency chain cannot be empty');
        }

        $depChain = array_values($depChain);
        $service = $depChain[0];
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
