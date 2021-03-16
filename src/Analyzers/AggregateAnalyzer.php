<?php

declare(strict_types=1);

namespace Dhii\Services\Tools\Analyzers;

use Dhii\Services\Tools\AnalyzerInterface;

/**
 * An analyzer implementation that aggregates issues from multiple other analyzers.
 */
class AggregateAnalyzer implements AnalyzerInterface
{
    /** @var AnalyzerInterface[] */
    protected $analyzers;

    /**
     * Constructor.
     *
     * @param AnalyzerInterface[] $analyzers The analyzers to aggregate.
     */
    public function __construct(array $analyzers)
    {
        $this->analyzers = $analyzers;
    }

    /** @inheritDoc */
    public function analyze(array $factories, array $extensions): iterable
    {
        foreach ($this->analyzers as $analyzer) {
            yield from $analyzer->analyze($factories, $extensions);
        }
    }
}
