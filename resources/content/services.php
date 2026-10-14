<?php

/*
|--------------------------------------------------------------------------
| Services
|--------------------------------------------------------------------------
|
| The order here is the order on the site. `origin` records where a service
| came from so it can be confirmed before launch:
|   existing-site  listed on the current techatronagency.com
|   proposed       added for the repositioning; confirm before launch
|
*/

return [

    'custom-software' => [
        'blurb' => 'Web apps, portals and internal platforms built around your processes.',
        'cta' => 'Planning a software project?',
        'origin' => 'proposed',
        'index' => '01',
        'name' => 'Custom Software & Web Applications',
        'short' => 'Custom software',
        'headline' => 'Software shaped around how your organisation actually works.',
        'summary' => 'We design and build web applications, internal platforms and customer-facing products when off-the-shelf tools force your business to bend around them.',
        'problem' => 'Critical operations run on spreadsheets, email threads and tools that were never meant to work together. Every workaround adds cost, risk and delay, and nobody has a single, reliable view of what is happening.',
        'audience' => [
            'Operations teams running on manual processes',
            'Founders turning a validated idea into a product',
            'Organisations replacing legacy or unsupported systems',
        ],
        'capabilities' => [
            'Web applications and customer portals',
            'Internal tools, dashboards and back-office systems',
            'Workflow automation and approvals',
            'Multi-tenant SaaS platforms',
            'Modernisation of legacy applications',
        ],
        'value' => [
            'One system of record instead of scattered spreadsheets',
            'Processes that run the same way every time',
            'Software your team can extend as the business grows',
        ],
        'deliverables' => [
            'Requirements and solution architecture',
            'UX flows and interface design',
            'Production-ready, tested application',
            'Source code, documentation and handover',
        ],
    ],

    'mobile-apps' => [
        'blurb' => 'iOS and Android apps, backed by reliable APIs.',
        'cta' => 'Planning a mobile app?',
        'origin' => 'existing-site',
        'index' => '02',
        'name' => 'Mobile App Development',
        'short' => 'Mobile apps',
        'headline' => 'Mobile apps people keep on their home screen.',
        'summary' => 'We build mobile applications around your brand and your users, for iOS and Android, backed by the APIs and infrastructure to run them reliably.',
        'problem' => 'Customers and field teams expect to do things from their phone. An app that is slow, crashes or ignores how people really use it costs you trust, and app-store ratings make the damage public.',
        'audience' => [
            'Businesses serving customers on mobile',
            'Organisations with staff working in the field',
            'Product teams launching a new digital service',
        ],
        'capabilities' => [
            'iOS and Android applications',
            'Cross-platform development from one codebase',
            'Offline-first experiences for low-connectivity areas',
            'Payments, notifications and location features',
            'Backend APIs and admin consoles',
        ],
        'value' => [
            'A product experience that reflects your brand',
            'Reach on both major platforms without doubling the cost',
            'An app that keeps working when the network does not',
        ],
        'deliverables' => [
            'Product discovery and user journeys',
            'Interface design and interactive prototype',
            'Tested apps published to the App Store and Google Play',
            'Release process and post-launch support',
        ],
    ],

    'cloud-infrastructure' => [
        'blurb' => 'Migration, hosting, monitoring and cost control.',
        'cta' => 'Rethinking your infrastructure?',
        'origin' => 'existing-site',
        'index' => '03',
        'name' => 'Cloud & Infrastructure',
        'short' => 'Cloud & infrastructure',
        'headline' => 'Infrastructure that stays up, scales sensibly and costs what it should.',
        'summary' => 'We help you choose, migrate to and operate the right cloud and hosting setup for your workload, with security, monitoring and cost control designed in.',
        'problem' => 'Systems that live on a single server, or in a cloud account nobody fully understands, fail at the worst possible moment. Bills creep up, backups go untested, and outages are discovered by customers first.',
        'audience' => [
            'Businesses moving off on-premise servers',
            'Teams whose cloud costs or complexity have grown',
            'Products preparing for a step change in traffic',
        ],
        'capabilities' => [
            'Cloud strategy and platform selection',
            'Migration from on-premise or legacy hosting',
            'Infrastructure as code and automated deployment',
            'Monitoring, alerting, backup and recovery',
            'Cost reviews and right-sizing',
        ],
        'value' => [
            'Fewer outages, and faster recovery when they happen',
            'Predictable infrastructure spend',
            'Environments you can rebuild from code, not memory',
        ],
        'deliverables' => [
            'Current-state assessment and target architecture',
            'Migration plan with rollback steps',
            'Automated, documented environments',
            'Runbooks and monitoring dashboards',
        ],
    ],

    'systems-integration' => [
        'blurb' => 'APIs connecting payments, ERPs, CRMs and partners.',
        'cta' => 'Need your systems to work together?',
        'origin' => 'proposed',
        'index' => '04',
        'name' => 'APIs & Systems Integration',
        'short' => 'APIs & integration',
        'headline' => 'Make the systems you already own work as one.',
        'summary' => 'We design APIs and connect the platforms your business depends on, from payments and ERPs to CRMs and government services, so data moves without re-keying.',
        'problem' => 'Staff copy the same data between systems by hand. Errors creep in, reports disagree, and every new tool adds another island of information.',
        'audience' => [
            'Organisations running several disconnected platforms',
            'Products that need payments, messaging or identity services',
            'Partners exchanging data with other businesses',
        ],
        'capabilities' => [
            'REST and webhook API design and development',
            'Payment gateway and messaging integrations',
            'ERP, CRM and accounting system integration',
            'Data synchronisation and migration',
            'Developer documentation for your own APIs',
        ],
        'value' => [
            'Data entered once and trusted everywhere',
            'Less manual work and fewer reconciliation errors',
            'A foundation for new channels and partners',
        ],
        'deliverables' => [
            'Integration map and data contracts',
            'Secured, versioned APIs',
            'Automated tests against each integration',
            'API documentation and monitoring',
        ],
    ],

    'managed-it' => [
        'blurb' => 'Support, monitoring and management for your IT.',
        'cta' => 'Looking for a dependable IT partner?',
        'origin' => 'existing-site',
        'index' => '05',
        'name' => 'Managed IT Services',
        'short' => 'Managed IT',
        'headline' => 'We run your technology so your team can run the business.',
        'summary' => 'Day-to-day IT support, management and monitoring for your systems, devices and users, with clear responsibilities and a team that knows your environment.',
        'problem' => 'IT problems land on whoever is nearest. Updates are skipped, access is never revoked, and small issues become expensive outages because nobody owns them.',
        'audience' => [
            'Growing businesses without an in-house IT team',
            'Organisations whose IT staff are stretched',
            'Multi-site teams that need consistent support',
        ],
        'capabilities' => [
            'Helpdesk and user support',
            'Device, account and licence management',
            'Proactive monitoring and patching',
            'Backup management and recovery testing',
            'Supplier and vendor coordination',
        ],
        'value' => [
            'One accountable partner for your technology',
            'Problems caught before they reach your customers',
            'Staff focused on their work, not on IT',
        ],
        'deliverables' => [
            'Onboarding audit of systems and access',
            'Agreed support scope and escalation path',
            'Monitoring and regular health reports',
            'Documented environment and asset register',
        ],
    ],

    'cybersecurity' => [
        'blurb' => 'Assessments, hardening and incident readiness.',
        'cta' => 'Concerned about your security?',
        'origin' => 'existing-site',
        'index' => '06',
        'name' => 'Cybersecurity',
        'short' => 'Cybersecurity',
        'headline' => 'Security treated as engineering, not an afterthought.',
        'summary' => 'We assess, harden and monitor your systems and the software we build, so protecting customer data and business continuity is part of how you operate.',
        'problem' => 'A single compromised account or unpatched server can expose customer data, halt operations and trigger regulatory obligations. Most breaches exploit basics that were never put in place.',
        'audience' => [
            'Organisations handling customer or financial data',
            'Businesses with data protection obligations',
            'Teams that have outgrown informal security practices',
        ],
        'capabilities' => [
            'Security assessments and remediation plans',
            'Identity, access and device security',
            'Secure configuration of cloud and email',
            'Secure software development practices',
            'Incident response planning',
        ],
        'value' => [
            'A clear picture of your real risks, ranked',
            'Practical controls your staff will actually follow',
            'Readiness to respond when something goes wrong',
        ],
        'deliverables' => [
            'Risk assessment with prioritised findings',
            'Hardening of identified systems',
            'Security policies sized to your organisation',
            'Incident response playbook',
        ],
    ],

    'technology-consulting' => [
        'blurb' => 'Strategy, roadmaps and independent technical advice.',
        'cta' => 'Need clear technical advice?',
        'origin' => 'proposed',
        'index' => '07',
        'name' => 'Technology Consulting & Digital Transformation',
        'short' => 'Technology consulting',
        'headline' => 'Clear technical judgement before you commit the budget.',
        'summary' => 'Independent advice on what to build, buy or retire, how to sequence it, and what it should cost, from engineers who have to live with the answer.',
        'problem' => 'Technology decisions get made on vendor pitches and guesswork. Projects start without clear scope, overrun, and leave behind systems that are expensive to change.',
        'audience' => [
            'Leadership teams planning a digital programme',
            'Organisations choosing between vendors or platforms',
            'Founders who need a technical partner before a team',
        ],
        'capabilities' => [
            'Technology strategy and roadmaps',
            'Build-versus-buy and vendor evaluation',
            'Architecture and code reviews',
            'Process digitisation planning',
            'Project rescue and recovery',
        ],
        'value' => [
            'Decisions grounded in engineering reality',
            'Budgets and timelines you can defend',
            'A plan that turns into working software',
        ],
        'deliverables' => [
            'Current-state assessment',
            'Options appraisal with costs and risks',
            'Phased roadmap',
            'Specification ready for delivery',
        ],
    ],

];
