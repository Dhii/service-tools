<?php

namespace Dhii\Services\Tools;

class Issue
{
    const SMELL = 0;
    const WARNING = 1;
    const ERROR = 2;

    /** @var int */
    protected $severity;

    /** @var string */
    protected $message;

    /**
     * Constructor.
     *
     * @param int    $severity
     * @param string $message
     */
    public function __construct(int $severity, string $message)
    {
        $this->severity = $severity;
        $this->message = $message;
    }

    /**
     * @return int
     */
    public function getSeverity(): int
    {
        return $this->severity;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
