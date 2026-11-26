<?php

use App\Models\ContactMessage;
use App\Models\Highlight;
use App\Models\Profile;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\TimelineEntry;

/*
 * Admin panel definitions. One generic CRUD controller and views read this file,
 * so adding a new editable section means adding one entry here.
 *
 * Field types: text, textarea, url, email, number, select, image, lines (one item per line)
 * "rules" are normal Laravel validation rules (string form).
 */
return [
    'resources' => [

        'profile' => [
            'title' => 'Profile & Hero',
            'model' => Profile::class,
            'singleton' => true,
            'fields' => [
                'full_name' => ['label' => 'Full name', 'type' => 'text', 'rules' => 'required|max:100'],
                'primary_title' => ['label' => 'Primary title', 'type' => 'text', 'rules' => 'required|max:100'],
                'hero_kicker' => ['label' => 'Hero kicker line', 'type' => 'text', 'rules' => 'nullable|max:200'],
                'hero_headline' => ['label' => 'Hero headline', 'type' => 'text', 'rules' => 'required|max:120'],
                'hero_subtitle' => ['label' => 'Hero subtitle', 'type' => 'text', 'rules' => 'nullable|max:100'],
                'hero_description' => ['label' => 'Hero description', 'type' => 'textarea', 'rules' => 'nullable|max:400'],
                'rotating_roles' => ['label' => 'Rotating roles (one per line)', 'type' => 'lines', 'rules' => 'nullable'],
                'location' => ['label' => 'Location', 'type' => 'text', 'rules' => 'nullable|max:150'],
                'email' => ['label' => 'Email', 'type' => 'email', 'rules' => 'nullable|email|max:160'],
                'phone' => ['label' => 'Phone', 'type' => 'text', 'rules' => 'nullable|max:40'],
                'linkedin' => ['label' => 'LinkedIn URL', 'type' => 'url', 'rules' => 'nullable|url|max:255'],
                'github' => ['label' => 'GitHub URL', 'type' => 'url', 'rules' => 'nullable|url|max:255'],
                'about_paragraphs' => ['label' => 'About paragraphs (one per line)', 'type' => 'lines', 'rules' => 'nullable'],
                'portrait_image' => ['label' => 'Portrait image', 'type' => 'image', 'rules' => 'nullable|image|max:4096'],
            ],
        ],

        'highlights' => [
            'title' => 'About Highlights',
            'model' => Highlight::class,
            'order' => 'sort_order',
            'fields' => [
                'label' => ['label' => 'Label', 'type' => 'text', 'rules' => 'required|max:120'],
                'detail' => ['label' => 'Detail', 'type' => 'text', 'rules' => 'nullable|max:200'],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number', 'rules' => 'nullable|integer'],
            ],
        ],

        'skills' => [
            'title' => 'Skills',
            'model' => Skill::class,
            'order' => 'sort_order',
            'fields' => [
                'category' => ['label' => 'Category', 'type' => 'select', 'options_from' => 'portfolio.skill_categories', 'rules' => 'required|in:backend,frontend,database,api,tools'],
                'name' => ['label' => 'Skill name', 'type' => 'text', 'rules' => 'required|max:120'],
                'detail' => ['label' => 'Short detail', 'type' => 'text', 'rules' => 'nullable|max:255'],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number', 'rules' => 'nullable|integer'],
            ],
        ],

        'projects' => [
            'title' => 'Projects',
            'model' => Project::class,
            'order' => 'sort_order',
            'fields' => [
                'title' => ['label' => 'Title', 'type' => 'text', 'rules' => 'required|max:150'],
                'category' => ['label' => 'Category', 'type' => 'text', 'rules' => 'nullable|max:120'],
                'summary' => ['label' => 'Summary (card text)', 'type' => 'textarea', 'rules' => 'nullable|max:500'],
                'description' => ['label' => 'Full description', 'type' => 'textarea', 'rules' => 'nullable|max:3000'],
                'features' => ['label' => 'Features (one per line)', 'type' => 'lines', 'rules' => 'nullable'],
                'technologies' => ['label' => 'Technologies (one per line)', 'type' => 'lines', 'rules' => 'nullable'],
                'image' => ['label' => 'Project image', 'type' => 'image', 'rules' => 'nullable|image|max:4096'],
                'repo_url' => ['label' => 'Repository URL', 'type' => 'url', 'rules' => 'nullable|url|max:255'],
                'live_url' => ['label' => 'Live URL', 'type' => 'url', 'rules' => 'nullable|url|max:255'],
                'status_note' => ['label' => 'Status note', 'type' => 'text', 'rules' => 'nullable|max:255'],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number', 'rules' => 'nullable|integer'],
            ],
        ],

        'timeline' => [
            'title' => 'Experience & Education',
            'model' => TimelineEntry::class,
            'order' => 'sort_order',
            'fields' => [
                'type' => ['label' => 'Type', 'type' => 'select', 'options' => ['experience' => 'Experience', 'education' => 'Education'], 'rules' => 'required|in:experience,education'],
                'title' => ['label' => 'Role / Degree', 'type' => 'text', 'rules' => 'required|max:150'],
                'subtitle' => ['label' => 'Company / University', 'type' => 'text', 'rules' => 'nullable|max:150'],
                'period_label' => ['label' => 'Period label', 'type' => 'text', 'rules' => 'nullable|max:150'],
                'details' => ['label' => 'Details (one per line)', 'type' => 'lines', 'rules' => 'nullable'],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number', 'rules' => 'nullable|integer'],
            ],
        ],

        'services' => [
            'title' => 'Services',
            'model' => Service::class,
            'order' => 'sort_order',
            'fields' => [
                'title' => ['label' => 'Title', 'type' => 'text', 'rules' => 'required|max:150'],
                'description' => ['label' => 'Description', 'type' => 'textarea', 'rules' => 'required|max:500'],
                'icon' => ['label' => 'Icon (Lucide name)', 'type' => 'select', 'options' => [
                    'globe' => 'Globe', 'code' => 'Code', 'layers' => 'Layers', 'server' => 'Server',
                    'layout-dashboard' => 'Layout', 'shopping-bag' => 'Shopping', 'database' => 'Database',
                    'webhook' => 'Webhook', 'credit-card' => 'Credit card', 'smartphone' => 'Smartphone',
                ], 'rules' => 'required|max:50'],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number', 'rules' => 'nullable|integer'],
            ],
        ],

        'process' => [
            'title' => 'Process Steps',
            'model' => ProcessStep::class,
            'order' => 'sort_order',
            'fields' => [
                'step' => ['label' => 'Step number (e.g. 01)', 'type' => 'text', 'rules' => 'required|max:10'],
                'title' => ['label' => 'Title', 'type' => 'text', 'rules' => 'required|max:100'],
                'summary' => ['label' => 'Summary', 'type' => 'textarea', 'rules' => 'required|max:500'],
                'deliverable' => ['label' => 'Deliverable', 'type' => 'text', 'rules' => 'nullable|max:255'],
                'sort_order' => ['label' => 'Sort order', 'type' => 'number', 'rules' => 'nullable|integer'],
            ],
        ],

        'messages' => [
            'title' => 'Contact Messages',
            'model' => ContactMessage::class,
            'order' => 'created_at',
            'dir' => 'desc',
            'readonly' => true,
            'fields' => [
                'full_name' => ['label' => 'Name', 'type' => 'text', 'rules' => ''],
                'email' => ['label' => 'Email', 'type' => 'email', 'rules' => ''],
                'subject' => ['label' => 'Subject', 'type' => 'text', 'rules' => ''],
                'message' => ['label' => 'Message', 'type' => 'textarea', 'rules' => ''],
            ],
        ],
    ],
];
