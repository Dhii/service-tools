<?php

namespace Dhii\Services\Tools\Analyzers;

use Dhii\Services\Tools\AnalyzerInterface;
use Dhii\Services\Tools\Issue;
use Dhii\Services\Tools\Issues\ServiceIssue;

/**
 * Detects extensions that don't extend any known factory.
 */
class InvalidExtensionAnalyzer implements AnalyzerInterface
{
    /** @inheritDoc */
    public function analyze(array $factories, array $extensions): iterable
    {
        foreach ($extensions as $key => $extension) {
            if (!array_key_exists($key, $factories)) {
                yield new ServiceIssue(
                    Issue::WARNING,
                    "Extension \"$key\" does not correspond to a known service",
                    $key
                );
            }
        }
    }
}
