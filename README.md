# Dhii - Service tools

A set of tools for working with service providers that use [`ServiceInterface`](service-interface).

## Analysis

This package provides a set of analyzers that can detect various kinds of service-related issues, such as:

* Circular dependencies
* Dependencies that don't resolve to known services
* Extensions that don't extend a known service

**Usage**:

```
$analyzer = new CircularDependencyAnalyzer();
$issues = $analyzer->analyze($factories, $extensions);

foreach ($issues as $issue) {
    $severity = $issue->getSeverity();
    $message = $issue->getMessage();
    
    switch ($severity) {
        case Issue::WARNING: /* do something */
        case Issue::ERROR:   /* do something */
    }
}
```

All the analyzers implement an [`AnalyzerInterface`](analyzer-interface). Container implementations can choose to
accept an analyzer instance during construction or setup using this interface, and then perform analysis on the
finished state of the container, after all [`ServiceProviderInterface`](service-provider) instances have been accepted.

Whether a container takes action on the reported issues or not is left up to the implementation. However, it is
strongly recommended that implementations take action according to the severity of the reported issues:

* `Issue::WARNING` - these issues should be reported to the developer; execution may resume.
* `Issue::ERROR` - these issues represent a fatal error waiting to happen; execution should probably stop.

[service-interface]: https://github.com/Dhii/services-interface
[analyzer-interface]: https://github.com/Dhii/service-tools/blob/initial/src/AnalyzerInterface.php
[service-provider]: https://github.com/container-interop/service-provider/blob/master/src/ServiceProviderInterface.php
