<?php

declare(strict_types=1);

namespace Dhii\Services\Tools\Issues;

class DependencyIssue extends ServiceIssue
{
    /** @var string */
    protected $dependency;

    /**
     * @inheritDoc
     *
     * @param string $dependency
     */
    public function __construct(int $severity, string $message, string $service, string $dependency)
    {
        parent::__construct($severity, $message, $service);
        $this->dependency = $dependency;
    }

    /**
     * @return string
     */
    public function getDependency(): string
    {
        return $this->dependency;
    }
}
