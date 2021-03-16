<?php

declare(strict_types=1);

namespace Dhii\Services\Tools\Issues;

use Dhii\Services\Tools\Issue;

/**
 * An issue related to a specific service.
 */
class ServiceIssue extends Issue
{
    /** @var string */
    protected $service;

    /**
     * @inheritDoc
     *
     * @param string $service The key of the service that is related to the issue.
     */
    public function __construct(int $severity, string $message, string $service)
    {
        parent::__construct($severity, $message);
        $this->service = $service;
    }

    /**
     * Retrieves the key of the service that is related to the issue.
     *
     * @return string A service key.
     */
    public function getService(): string
    {
        return $this->service;
    }
}
