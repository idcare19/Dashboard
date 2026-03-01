<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class PortfolioSetting extends Model
{
    protected $fillable = [
        'site_title',
        'person_name',
        'hero_title',
        'hero_subtitle',
        'availability',
        'location',
        'avatar_url',
        'contact_email',
        'popup_message',
        'badges',
        'stats',
        'about_cards',
        'projects',
        'skills',
        'experiences',
        'socials',
        'graph_points',
        'upcoming_projects',
        'updates_feed',
        'admin_notes',
    ];

    protected function casts(): array
    {
        return [
            'badges' => 'array',
            'stats' => 'array',
            'about_cards' => 'array',
            'projects' => 'array',
            'skills' => 'array',
            'experiences' => 'array',
            'socials' => 'array',
            'graph_points' => 'array',
            'upcoming_projects' => 'array',
            'updates_feed' => 'array',
        ];
    }

    public static function singleton(): self
    {
        try {
            return self::query()->first() ?? self::query()->create(self::defaults());
        } catch (QueryException) {
            return new self(self::defaults());
        }
    }

    public static function defaults(): array
    {
        return [
            'site_title' => 'Portfolio • ABHISHEK',
            'person_name' => 'Abhishek',
            'hero_title' => 'I design and build delightful web experiences.',
            'hero_subtitle' => 'Frontend Developer • Backend Developer • Full Stack Developer • UI/UX • Performance-focused • Open to freelance & internships',
            'availability' => 'Available for work',
            'location' => 'Based in India',
            'avatar_url' => 'https://images.unsplash.com/photo-1544006659-f0b21884ce1d?q=80&w=1200&auto=format&fit=crop',
            'contact_email' => 'dream1mm113@email.com',
            'popup_message' => '🚧 Dashboard project is under working',
            'badges' => [
                'Available for work',
                'Based in India',
                'Remote friendly',
            ],
            'stats' => [
                ['label' => 'Projects', 'value' => '6+'],
                ['label' => 'Experience', 'value' => '8m'],
                ['label' => 'Client rating', 'value' => '4.3'],
            ],
            'about_cards' => [
                [
                    'title' => 'Who I am',
                    'description' => 'I’m a developer focused on crafting fast, accessible, and beautiful interfaces. I love solving product problems and turning ideas into polished experiences.',
                    'tags' => ['Accessibility', 'Web Perf', 'Design Systems'],
                ],
                [
                    'title' => 'What I do',
                    'description' => 'Design and build responsive websites, full stack apps and component libraries. I collaborate end-to-end: discovery, UX, UI, development, and iteration.',
                    'tags' => ['HTML', 'CSS', 'Figma'],
                ],
                [
                    'title' => 'How I work',
                    'description' => 'Clear communication, fast prototypes, measurable outcomes. I value maintainability and documentation so your team can scale with confidence.',
                    'tags' => ['Agile', 'Docs', 'Testing'],
                ],
            ],
            'projects' => [
                [
                    'title' => 'Devfolio – Portfolio Template',
                    'description' => 'A blazing-fast, accessible portfolio template built with semantic HTML, modern CSS, and vanilla JS.',
                    'image_url' => 'https://images.unsplash.com/photo-1587620962725-abab7fe55159?q=80&w=1200&auto=format&fit=crop',
                    'live_url' => '#',
                    'code_url' => '#',
                    'tags' => ['HTML', 'CSS', 'JS'],
                ],
                [
                    'title' => 'Ecommerce clone',
                    'description' => 'Clean storefront with cart, filters, and checkout flow. Focused on clarity and conversion.',
                    'image_url' => 'https://images.unsplash.com/photo-1688561807440-8a57dfa77ee3?q=80&w=1170&auto=format&fit=crop',
                    'live_url' => 'https://ecommerce-website-clone-ruby.vercel.app',
                    'code_url' => 'https://github.com/idcare19/ecommerce-website-clone',
                    'tags' => ['HTML', 'CSS', 'JavaScript'],
                ],
                [
                    'title' => 'DashX – Analytics Dashboard',
                    'description' => 'Responsive dashboard with charts, dark mode, and keyboard navigation.',
                    'image_url' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1200&auto=format&fit=crop',
                    'live_url' => null,
                    'code_url' => null,
                    'tags' => ['React', 'Laravel'],
                ],
            ],
            'skills' => [
                ['name' => 'HTML/CSS', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg'],
                ['name' => 'JavaScript', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg'],
                ['name' => 'PHP', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg'],
                ['name' => 'MySQL', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg'],
                ['name' => 'Laravel', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg'],
                ['name' => 'React', 'icon' => 'https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg'],
            ],
            'experiences' => [
                [
                    'title' => 'Full Stack Developer • Freelance',
                    'period' => '2026 — Present',
                    'description' => 'Providing end-to-end web development and cybersecurity solutions. Building secure, scalable applications and advising clients on security best practices.',
                ],
            ],
            'socials' => [
                ['platform' => 'Email', 'url' => 'mailto:dream1mm113@email.com', 'handle' => 'dream1mm113@email.com'],
                ['platform' => 'GitHub', 'url' => 'https://github.com/idcare19', 'handle' => '@idcare19'],
                ['platform' => 'LinkedIn', 'url' => 'https://linkedin.com/in/abhishekidcare19', 'handle' => '/in/abhishekidcare19'],
                ['platform' => 'Twitter / X', 'url' => 'https://twitter.com/idcare19_', 'handle' => '@idcare19_'],
            ],
            'graph_points' => [12, 18, 15, 26, 31, 28, 34],
            'upcoming_projects' => [
                [
                    'title' => 'AI Resume Builder',
                    'eta' => 'Q2 2026',
                    'details' => 'Smart resume generation with portfolio sync and ATS scoring.',
                ],
                [
                    'title' => 'Secure Client Portal',
                    'eta' => 'Q3 2026',
                    'details' => 'Client dashboards with session-safe auth and encrypted file exchange.',
                ],
            ],
            'updates_feed' => [
                [
                    'title' => 'Portfolio migrated to dynamic Laravel setup',
                    'date' => '2026-03-01',
                ],
                [
                    'title' => 'Added user CRUD, role access, and session login',
                    'date' => '2026-03-01',
                ],
            ],
            'admin_notes' => 'Admin-only notes: revenue metrics, private client data, internal roadmap.',
        ];
    }
}
