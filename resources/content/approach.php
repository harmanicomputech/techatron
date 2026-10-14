<?php

/*
| How a project moves from idea to dependable product. Used on the homepage
| and the /approach page.
*/

return [
    [
        'key' => 'discover',
        'name' => 'Discover',
        'summary' => 'We learn the business before we touch the technology: the goal, the people involved, the constraints and what success has to look like.',
        'activities' => ['Stakeholder interviews', 'Process and system mapping', 'Risks and constraints', 'Success measures agreed'],
        'output' => 'Discovery brief',
    ],
    [
        'key' => 'architect',
        'name' => 'Architect',
        'summary' => 'We choose the simplest architecture that will hold up: how data flows, what to build or buy, where security and scale matter, and what it will cost to run.',
        'activities' => ['Solution architecture', 'Technology selection', 'Security and data model', 'Estimate and delivery plan'],
        'output' => 'Architecture and fixed scope',
    ],
    [
        'key' => 'design',
        'name' => 'Design',
        'summary' => 'We turn requirements into flows and interfaces your users can test before a line of production code is written.',
        'activities' => ['User journeys', 'Wireframes', 'Interface design', 'Clickable prototype'],
        'output' => 'Validated prototype',
    ],
    [
        'key' => 'engineer',
        'name' => 'Engineer',
        'summary' => 'We build in short, visible increments. You see working software regularly, not a big reveal at the end.',
        'activities' => ['Iterative delivery', 'Code review on every change', 'Automated testing', 'Regular demos'],
        'output' => 'Working software, every iteration',
    ],
    [
        'key' => 'assure',
        'name' => 'Assure',
        'summary' => 'Quality is checked continuously, then confirmed end to end: function, performance, security and accessibility.',
        'activities' => ['Functional and regression testing', 'Performance checks', 'Security review', 'User acceptance'],
        'output' => 'Release sign-off',
    ],
    [
        'key' => 'launch',
        'name' => 'Launch & evolve',
        'summary' => 'We deploy with monitoring and a rollback plan, hand over documentation, and stay on to support, improve and extend what we built.',
        'activities' => ['Automated deployment', 'Monitoring and alerting', 'Documentation and training', 'Ongoing support'],
        'output' => 'Live product, supported',
    ],
];
