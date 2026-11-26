<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use App\Models\Highlight;
use App\Models\Profile;
use App\Models\ProcessStep;
use App\Models\Project;
use App\Models\Service;
use App\Models\Skill;
use App\Models\TimelineEntry;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Admin login. CHANGE this password after the first login.
        User::updateOrCreate(
            ['email' => 'admin@example.com'],
            ['name' => 'Harwinder Singh', 'password' => Hash::make('password')]
        );

        Profile::updateOrCreate(['id' => 1], [
            'full_name' => 'Harwinder Singh',
            'primary_title' => 'Web Developer',
            'hero_kicker' => 'Web Developer · Tohana, Haryana, India · Open to Opportunities',
            'hero_headline' => "Hi, I'm Harwinder Singh.",
            'hero_subtitle' => 'Creative Web Developer',
            'hero_description' => 'I build modern, interactive, and powerful digital experiences that bring ideas to life.',
            'rotating_roles' => ['Web Developer', 'Full Stack Developer', 'Backend Developer', 'PHP Developer', 'Creative Developer'],
            'location' => 'Tohana, Haryana, India',
            'email' => 'harwindersingh200509@gmail.com',
            'phone' => '+91 94165 77238',
            'linkedin' => 'https://www.linkedin.com/in/harwinder-singh-465880315',
            'github' => 'https://github.com/HarwinderSingh2005',
            'about_paragraphs' => [
                'I am Harwinder Singh, a passionate Web Developer and BCA graduate with practical experience in building modern, responsive, and database-driven web applications.',
                'I work with PHP, Laravel, MySQL, HTML, CSS, JavaScript, Blade, and Livewire. I enjoy creating user-friendly interfaces, developing powerful backend functionality, managing databases, integrating APIs, and building secure and scalable web applications.',
                'My goal is to create meaningful digital experiences by combining creative design with strong development skills.',
            ],
            'portrait_image' => '/images/harwinder_portrait_1795259155655.jpg',
        ]);

        // Start clean so the seeder can be re-run safely.
        foreach ([Highlight::class, Skill::class, Project::class, TimelineEntry::class, Service::class, ProcessStep::class] as $model) {
            $model::query()->delete();
        }

        $highlights = [
            ['BCA Graduate', 'Choudhary Devi Lal University'],
            ['Web Development Intern', 'Rednirus Digital Media'],
            ['PHP & Laravel Experience', 'MVC architecture, Eloquent ORM, Blade & Livewire'],
            ['Database-Driven Applications', 'MySQL schema design, migrations, and CRUD workflows'],
        ];
        foreach ($highlights as $i => [$label, $detail]) {
            Highlight::create(['label' => $label, 'detail' => $detail, 'sort_order' => $i + 1]);
        }

        $skills = [
            'backend' => [
                ['PHP', 'Server-side scripting and structured web logic'],
                ['Laravel', 'Full-stack framework for scalable web apps'],
                ['MVC Architecture', 'Clean separation of models, views, controllers'],
                ['Eloquent ORM', 'Relational model queries and relationships'],
                ['Routing', 'Clean RESTful and web endpoint organization'],
                ['Middleware', 'Request filtering, auth guards, and protection'],
                ['Validation', 'Strict server-side input verification rules'],
            ],
            'frontend' => [
                ['HTML5', 'Semantic, accessible document architecture'],
                ['CSS3', 'Modern layouts, transitions, and visual polish'],
                ['JavaScript', 'Interactive UI behavior and async requests'],
                ['Responsive Web Design', 'Consistent experience across desktop and mobile'],
                ['Blade Templates', 'Reusable components and clean layout inheritance'],
                ['Livewire', 'Reactive dynamic interfaces backed by PHP'],
            ],
            'database' => [
                ['MySQL', 'Structured relational data storage and querying'],
                ['Relational Database Design', 'Normalized tables, keys, and relations'],
                ['Migrations', 'Version-controlled schema evolution'],
                ['Seeders', 'Reproducible baseline datasets for testing'],
                ['CRUD Operations', 'End-to-end create, read, update, delete flows'],
            ],
            'api' => [
                ['REST APIs', 'Integrating and consuming external web services'],
                ['JSON', 'Structured data exchange and API serialization'],
                ['Stripe Checkout Integration', 'Hosted payment flows and order callbacks'],
            ],
            'tools' => [
                ['Git', 'Branching, commits, and clean source history'],
                ['GitHub', 'Remote repositories and collaborative code hosting'],
                ['Composer', 'PHP dependency management and autoloading'],
                ['npm', 'Frontend build tools and package scripts'],
                ['VS Code', 'Configured workspace for full-stack development'],
                ['XAMPP', 'Local Apache, PHP, and MySQL environment'],
            ],
        ];
        $order = 0;
        foreach ($skills as $category => $items) {
            foreach ($items as [$name, $detail]) {
                Skill::create(['category' => $category, 'name' => $name, 'detail' => $detail, 'sort_order' => ++$order]);
            }
        }

        $projects = [
            [
                'title' => 'Laravel E-Commerce / Admin Panel',
                'category' => 'Full Stack Application',
                'summary' => 'Modular administration system for managing products, categories, brands, pricing, inventory stock, and SEO metadata.',
                'description' => 'Developed structured project modules for managing products, categories, brands, pricing, stock levels, and SEO metadata within a unified Laravel Admin Dashboard powered by Eloquent ORM and MySQL.',
                'features' => ['Product Management', 'Category Management', 'Brand Management', 'Pricing Management', 'Stock Management', 'SEO Metadata', 'Admin Dashboard'],
                'technologies' => ['PHP', 'Laravel', 'MySQL', 'Blade', 'Eloquent ORM'],
                'image' => '/images/project_ecommerce_admin_1795259155963.jpg',
                'status_note' => 'Repository & architecture details available via GitHub',
            ],
            [
                'title' => 'Pharmacy Website / Product Catalog',
                'category' => 'Database-Driven Web App',
                'summary' => 'Healthcare-focused product catalog featuring category browsing, search-friendly URLs, pagination, and SEO fields.',
                'description' => 'Worked on a pharmacy-focused website with structured product listings, category browsing, search-friendly page hierarchy, database-backed product management, pagination, and configurable SEO fields.',
                'features' => ['Product Listings & Filtering', 'Category Browsing Structure', 'Search-Friendly Page Architecture', 'Database-Backed Product Management', 'Server-Side Pagination', 'SEO Metadata Fields'],
                'technologies' => ['Laravel', 'PHP', 'MySQL', 'HTML', 'CSS', 'JavaScript'],
                'image' => '/images/project_pharmacy_catalog_1795259155870.jpg',
                'status_note' => 'Source code configurable via GitHub profile',
            ],
            [
                'title' => 'Stripe Checkout Integration',
                'category' => 'Payment Flow Architecture',
                'summary' => 'Laravel payment-flow practice implementation integrating Stripe Checkout sessions, redirection, and confirmation handling.',
                'description' => 'Built a Laravel payment-flow practice project using Stripe Checkout for test purchases, handling session creation, secure checkout redirection, callback routing, and order confirmation views.',
                'features' => ['Stripe Checkout Session Creation', 'Secure Payment Redirection', 'Success Page Handling', 'End-to-End Payment Flow Validation'],
                'technologies' => ['Laravel', 'PHP', 'Stripe API'],
                'image' => '/images/project_stripe_checkout_1795259157370.jpg',
                'status_note' => 'Practice integration built with Stripe test mode',
            ],
        ];
        foreach ($projects as $i => $project) {
            Project::create($project + ['repo_url' => 'https://github.com/HarwinderSingh2005', 'sort_order' => $i + 1]);
        }

        TimelineEntry::create([
            'type' => 'experience',
            'title' => 'Web Development Intern',
            'subtitle' => 'Rednirus Digital Media',
            'period_label' => 'Internship Experience (dates to be added)',
            'details' => [
                'Contribute to web development tasks across real project workflows.',
                'Gain practical experience with structured web application architecture.',
                'Work hands-on with both frontend and backend technologies.',
                'Debug and implement application features cleanly and reliably.',
                'Develop and test web application functionality for responsive behavior.',
            ],
            'sort_order' => 1,
        ]);

        TimelineEntry::create([
            'type' => 'education',
            'title' => 'Bachelor of Computer Applications (BCA)',
            'subtitle' => 'Choudhary Devi Lal University',
            'period_label' => 'Graduation year (to be added)',
            'details' => ['Foundations in computer science, relational database systems, software engineering principles, and web technologies.'],
            'sort_order' => 1,
        ]);

        $services = [
            ['Custom Website Development', 'Bespoke websites engineered from scratch for speed, clarity, and brand identity.', 'globe'],
            ['PHP Web Development', 'Reliable server-side applications with clean, maintainable PHP codebases.', 'code'],
            ['Laravel Web Applications', 'Structured MVC web platforms built with routing, middleware, and Eloquent ORM.', 'layers'],
            ['Backend Development', 'Secure business logic, authentication flows, and server-side validation.', 'server'],
            ['Admin Panel Development', 'Intuitive control dashboards for managing products, content, users, and stock.', 'layout-dashboard'],
            ['E-commerce Website Development', 'Catalog-driven online stores with category structures, pricing, and SEO.', 'shopping-bag'],
            ['Database Management', 'Normalized MySQL schemas, migrations, seeders, and dependable CRUD operations.', 'database'],
            ['REST API Integration', 'Seamless third-party service integrations and structured JSON data exchange.', 'webhook'],
            ['Payment Gateway Integration', 'Stripe Checkout flows with secure redirection and confirmation handling.', 'credit-card'],
            ['Responsive Website Development', 'Fluid interfaces engineered for mobile, tablet, laptop, and widescreen displays.', 'smartphone'],
        ];
        foreach ($services as $i => [$title, $description, $icon]) {
            Service::create(['title' => $title, 'description' => $description, 'icon' => $icon, 'sort_order' => $i + 1]);
        }

        $steps = [
            ['01', 'Discover', 'Understand the requirements, business context, and core project goals.', 'Clear scope and feature priorities'],
            ['02', 'Plan', 'Plan the application structure, key features, routes, and database schema.', 'Data models and technical blueprint'],
            ['03', 'Design', 'Create modern, accessible, and user-friendly interfaces with visual clarity.', 'Responsive UI layouts and interactions'],
            ['04', 'Develop', 'Build frontend views and backend functionality with clean, structured code.', 'Working full-stack implementation'],
            ['05', 'Test', 'Verify functionality, form validation, responsiveness, and overall performance.', 'Cross-device QA and bug fixes'],
            ['06', 'Deliver', 'Prepare the completed, documented application cleanly for deployment.', 'Production-ready launch package'],
        ];
        foreach ($steps as $i => [$step, $title, $summary, $deliverable]) {
            ProcessStep::create(['step' => $step, 'title' => $title, 'summary' => $summary, 'deliverable' => $deliverable, 'sort_order' => $i + 1]);
        }
    }
}
