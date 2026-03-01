-- InfinityFree full import for Mydash (Laravel)
-- Generated: 2026-03-01
-- Import in phpMyAdmin (SQL tab) after selecting your database.

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `dashboard_access_requests`;
DROP TABLE IF EXISTS `contact_messages`;
DROP TABLE IF EXISTS `portfolio_settings`;
DROP TABLE IF EXISTS `failed_jobs`;
DROP TABLE IF EXISTS `job_batches`;
DROP TABLE IF EXISTS `jobs`;
DROP TABLE IF EXISTS `cache_locks`;
DROP TABLE IF EXISTS `cache`;
DROP TABLE IF EXISTS `sessions`;
DROP TABLE IF EXISTS `password_reset_tokens`;
DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text,
  `payload` longtext NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`),
  KEY `cache_locks_expiration_index` (`expiration`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `portfolio_settings` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `site_title` varchar(255) NOT NULL DEFAULT 'Portfolio',
  `person_name` varchar(255) NOT NULL DEFAULT 'Abhishek',
  `hero_title` text NOT NULL,
  `hero_subtitle` text NOT NULL,
  `availability` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `avatar_url` varchar(255) DEFAULT NULL,
  `contact_email` varchar(255) DEFAULT NULL,
  `popup_message` varchar(255) DEFAULT NULL,
  `badges` longtext DEFAULT NULL,
  `stats` longtext DEFAULT NULL,
  `about_cards` longtext DEFAULT NULL,
  `projects` longtext DEFAULT NULL,
  `skills` longtext DEFAULT NULL,
  `experiences` longtext DEFAULT NULL,
  `socials` longtext DEFAULT NULL,
  `graph_points` longtext DEFAULT NULL,
  `upcoming_projects` longtext DEFAULT NULL,
  `updates_feed` longtext DEFAULT NULL,
  `admin_notes` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `dashboard_access_requests` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `message` text,
  `status` varchar(255) NOT NULL DEFAULT 'pending',
  `access_key_hash` varchar(255) DEFAULT NULL,
  `access_key_expires_at` timestamp NULL DEFAULT NULL,
  `approved_by` bigint unsigned DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dashboard_access_requests_approved_by_foreign` (`approved_by`),
  CONSTRAINT `dashboard_access_requests_approved_by_foreign` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `contact_messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `email` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Seed users
-- Password for both users: ChangeMeNow!123
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Abhishek Admin', 'admin@example.com', NULL, '$2y$10$m7iT0f0kblquRErUjGHhjevskF13Ef9Up.MbTcFpxgxzxCSJs9jVS', 'admin', NULL, NOW(), NOW()),
(2, 'Normal User', 'user@example.com', NULL, '$2y$10$m7iT0f0kblquRErUjGHhjevskF13Ef9Up.MbTcFpxgxzxCSJs9jVS', 'user', NULL, NOW(), NOW());

-- Seed default portfolio data
INSERT INTO `portfolio_settings` (
  `id`, `site_title`, `person_name`, `hero_title`, `hero_subtitle`, `availability`, `location`,
  `avatar_url`, `contact_email`, `popup_message`, `badges`, `stats`, `about_cards`, `projects`,
  `skills`, `experiences`, `socials`, `graph_points`, `upcoming_projects`, `updates_feed`, `admin_notes`,
  `created_at`, `updated_at`
) VALUES (
  1,
  'Portfolio • ABHISHEK',
  'Abhishek',
  'I design and build delightful web experiences.',
  'Frontend Developer • Backend Developer • Full Stack Developer • UI/UX • Performance-focused • Open to freelance & internships',
  'Available for work',
  'Based in India',
  'https://images.unsplash.com/photo-1544006659-f0b21884ce1d?q=80&w=1200&auto=format&fit=crop',
  'dream1mm113@email.com',
  '🚧 Dashboard project is under working',
  '["Available for work","Based in India","Remote friendly"]',
  '[{"label":"Projects","value":"6+"},{"label":"Experience","value":"8m"},{"label":"Client rating","value":"4.3"}]',
  '[{"title":"Who I am","description":"I\'m a developer focused on crafting fast, accessible, and beautiful interfaces. I love solving product problems and turning ideas into polished experiences.","tags":["Accessibility","Web Perf","Design Systems"]},{"title":"What I do","description":"Design and build responsive websites, full stack apps and component libraries. I collaborate end-to-end: discovery, UX, UI, development, and iteration.","tags":["HTML","CSS","Figma"]},{"title":"How I work","description":"Clear communication, fast prototypes, measurable outcomes. I value maintainability and documentation so your team can scale with confidence.","tags":["Agile","Docs","Testing"]}]',
  '[{"title":"Devfolio – Portfolio Template","description":"A blazing-fast, accessible portfolio template built with semantic HTML, modern CSS, and vanilla JS.","image_url":"https://images.unsplash.com/photo-1587620962725-abab7fe55159?q=80&w=1200&auto=format&fit=crop","live_url":"#","code_url":"#","tags":["HTML","CSS","JS"]},{"title":"Ecommerce clone","description":"Clean storefront with cart, filters, and checkout flow. Focused on clarity and conversion.","image_url":"https://images.unsplash.com/photo-1688561807440-8a57dfa77ee3?q=80&w=1170&auto=format&fit=crop","live_url":"https://ecommerce-website-clone-ruby.vercel.app","code_url":"https://github.com/idcare19/ecommerce-website-clone","tags":["HTML","CSS","JavaScript"]},{"title":"DashX – Analytics Dashboard","description":"Responsive dashboard with charts, dark mode, and keyboard navigation.","image_url":"https://images.unsplash.com/photo-1519389950473-47ba0277781c?q=80&w=1200&auto=format&fit=crop","live_url":null,"code_url":null,"tags":["React","Laravel"]}]',
  '[{"name":"HTML/CSS","icon":"https://cdn.jsdelivr.net/gh/devicons/devicon/icons/html5/html5-original.svg"},{"name":"JavaScript","icon":"https://cdn.jsdelivr.net/gh/devicons/devicon/icons/javascript/javascript-original.svg"},{"name":"PHP","icon":"https://cdn.jsdelivr.net/gh/devicons/devicon/icons/php/php-original.svg"},{"name":"MySQL","icon":"https://cdn.jsdelivr.net/gh/devicons/devicon/icons/mysql/mysql-original.svg"},{"name":"Laravel","icon":"https://cdn.jsdelivr.net/gh/devicons/devicon/icons/laravel/laravel-original.svg"},{"name":"React","icon":"https://cdn.jsdelivr.net/gh/devicons/devicon/icons/react/react-original.svg"}]',
  '[{"title":"Full Stack Developer • Freelance","period":"2026 — Present","description":"Providing end-to-end web development and cybersecurity solutions. Building secure, scalable applications and advising clients on security best practices."}]',
  '[{"platform":"Email","url":"mailto:dream1mm113@email.com","handle":"dream1mm113@email.com"},{"platform":"GitHub","url":"https://github.com/idcare19","handle":"@idcare19"},{"platform":"LinkedIn","url":"https://linkedin.com/in/abhishekidcare19","handle":"/in/abhishekidcare19"},{"platform":"Twitter / X","url":"https://twitter.com/idcare19_","handle":"@idcare19_"}]',
  '[12,18,15,26,31,28,34]',
  '[{"title":"AI Resume Builder","eta":"Q2 2026","details":"Smart resume generation with portfolio sync and ATS scoring."},{"title":"Secure Client Portal","eta":"Q3 2026","details":"Client dashboards with session-safe auth and encrypted file exchange."}]',
  '[{"title":"Portfolio migrated to dynamic Laravel setup","date":"2026-03-01"},{"title":"Added user CRUD, role access, and session login","date":"2026-03-01"}]',
  'Admin-only notes: revenue metrics, private client data, internal roadmap.',
  NOW(), NOW()
);

SET FOREIGN_KEY_CHECKS=1;
