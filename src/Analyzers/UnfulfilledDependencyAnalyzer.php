<?php

namespace Dhii\Services\Tools\Analyzers;

use Dhii\Services\Tools\AnalyzerInterface;
use Dhii\Services\Tools\Issue;
use Dhii\Services\Tools\Issues\DependencyIssue;
use Dhii\Services\Tools\Utils\GetServiceDepsCapableTrait;

/**
 * Detects service dependencies that cannot be resolved to existing services.
 */
class UnfulfilledDependencyAnalyzer implements AnalyzerInterface
{
    use GetServiceDepsCapableTrait;

    /** @inheritDoc */
    public function analyze(array $factories, array $extensions): iterable
    {
        yield from $this->scan($factories, $factories);
        yield from $this->scan($factories, $extensions);
    }

    public function scan(array $factories, array $services): iterable
    {
        foreach ($services as $key => $service) {
            $deps = $this->getServiceDeps($service);

            foreach ($deps as $dep) {
                if (!array_key_exists($dep, $factories)) {
                    yield new DependencyIssue(Issue::WARNING, 'Unfulfilled dependency', $key, $dep);
                }
            }
        }
    }
}
