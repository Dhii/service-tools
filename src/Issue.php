<?php

declare(strict_types=1);

namespace Dhii\Services\Tools;

class Issue
{
    /** Tame severity for an issue that deserves attention but might not require termination. */
    public const WARNING = 0;
    /** High severity for an issue that should be reported and is likely to require terminating. */
    public const ERROR = 1;

    /** @var int */
    protected $severity;

    /** @var string */
    protected $message;

    /**
     * Constructor.
     *
     * @param int    $severity The severity of the issue. See {@link Issue::WARNING} and {@link Issue::ERROR}.
     * @param string $message  A human-friendly message describing the issue.
     */
    public function __construct(int $severity, string $message)
    {
        $this->severity = $severity;
        $this->message = $message;
    }

    /**
     * Retrieves the severity of the issue.
     *
     * @see Issue::WARNING
     * @see Issue::ERROR
     *
     * @return int See the constants in {@link Issue}.
     */
    public function getSeverity(): int
    {
        return $this->severity;
    }

    /**
     * Retrieves a message that describes the issue in a human-friendly manner.
     *
     * @return string The message.
     */
    public function getMessage(): string
    {
        return $this->message;
    }
}
