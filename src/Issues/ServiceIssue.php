<?php

namespace Dhii\Services\Tools\Issues;

use Dhii\Services\Tools\Issue;

class ServiceIssue extends Issue
{
    /** @var string */
    protected $service;

    /**
     * @inheritDoc
     *
     * @param string $service
     */
    public function __construct(int $severity, string $message, string $service)
    {
        parent::__construct($severity, $message);
        $this->service = $service;
    }

    /**
     * @return string
     */
    public function getService(): string
    {
        return $this->service;
    }
}
