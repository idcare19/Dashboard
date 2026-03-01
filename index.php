<?php

/**
 * Fallback front controller for environments where Apache/Nginx document root
 * is set to the project root instead of /public.
 */

require __DIR__ . '/public/index.php';
