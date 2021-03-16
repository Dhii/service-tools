<?php

declare(strict_types=1);

namespace Dhii\Services\Tools\Issues;

/**
 * An issue related to a specific service and one of its dependencies.
 */
class DependencyIssue extends ServiceIssue
{
    /** @var string */
    protected $dependency;

    /**
     * @inheritDoc
     *
     * @param string $dependency The key of the dependency that is relevant to the issue.
     */
    public function __construct(int $severity, string $message, string $service, string $dependency)
    {
        parent::__construct($severity, $message, $service);
        $this->dependency = $dependency;
    }

    /**
     * Retrieves the key of the dependency that is relevant to the issue.
     *
     * @return string A dependency key.
     */
    public function getDependency(): string
    {
        return $this->dependency;
    }
}
