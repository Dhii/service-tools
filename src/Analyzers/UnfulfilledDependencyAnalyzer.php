<?php

declare(strict_types=1);

namespace Dhii\Services\Tools\Analyzers;

use Dhii\Services\ServiceInterface;
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

    /**
     * Scans a list of services to find if any of them have dependencies that don't resolve to existing services.
     *
     * @param array<callable|ServiceInterface> $factories The entire list of factories against which dependency
     *                                                    existence will be determined.
     * @param array<callable|ServiceInterface> $services  The list of services to scan.
     *
     * @return iterable<Issue> A list of found issues.
     */
    public function scan(array $factories, array $services): iterable
    {
        foreach ($services as $key => $service) {
            $deps = $this->getServiceDeps($service);

            foreach ($deps as $dep) {
                if (!array_key_exists($dep, $factories)) {
                    yield new DependencyIssue(
                        Issue::WARNING,
                        "Service \"$key\" has an unfulfilled dependency: \"$dep\"",
                        $key,
                        $dep
                    );
                }
            }
        }
    }
}
