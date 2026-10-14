<?php

/*
| Quality attributes designed for from the first conversation. These describe
| practice, not outcomes; confirm they match how Techatron works.
*/

return [
    ['name' => 'Reliability', 'spec' => 'monitoring · backups · rollback', 'body' => 'Systems are built to fail safely and recover quickly, with monitoring that tells us before your customers do.'],
    ['name' => 'Security', 'spec' => 'least privilege · encryption · review', 'body' => 'Access control, data protection and secure defaults are part of the architecture, not a checklist at the end.'],
    ['name' => 'Performance', 'spec' => 'budgets · profiling · caching', 'body' => 'We set performance budgets early and test against them, including on the mid-range phones and networks your users actually have.'],
    ['name' => 'Maintainability', 'spec' => 'tests · docs · conventions', 'body' => 'Readable code, automated tests and documentation mean the software stays affordable to change long after launch.'],
    ['name' => 'Scalability', 'spec' => 'stateless · queues · IaC', 'body' => 'We design for the growth you expect, not the growth of a hypothetical unicorn, and keep the path to the next stage open.'],
    ['name' => 'Integration', 'spec' => 'APIs · webhooks · contracts', 'body' => 'Clean, documented interfaces let your software connect to partners, payment providers and the tools you adopt next.'],
];
