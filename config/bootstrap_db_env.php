<?php

/**
 * Load DB credentials from /include/db.php (outside web root) without executing it,
 * then expose DATABASE_URL for Symfony/Doctrine.
 */
$serverDbConfigCandidates = [
    '/include/db.php',
    dirname(__DIR__, 2).'/include/db.php',
    dirname(__DIR__, 3).'/include/db.php',
];

/** @return array{host:string,dbname:string,username:string,password:string}|null */
$extractCredentials = static function (string $filePath): ?array {
    $content = @file_get_contents($filePath);
    if ($content === false) {
        return null;
    }

    $patterns = [
        'host' => '/\$host\s*=\s*["\']([^"\']+)["\']\s*;/',
        'dbname' => '/\$dbname\s*=\s*["\']([^"\']+)["\']\s*;/',
        'username' => '/\$username\s*=\s*["\']([^"\']+)["\']\s*;/',
        'password' => '/\$password\s*=\s*["\']([^"\']*)["\']\s*;/',
    ];

    $values = [];

    foreach ($patterns as $key => $pattern) {
        if (!preg_match($pattern, $content, $matches)) {
            return null;
        }

        $values[$key] = $matches[1];
    }

    return $values;
};

foreach ($serverDbConfigCandidates as $dbConfigPath) {
    if (!is_file($dbConfigPath) || !is_readable($dbConfigPath)) {
        continue;
    }

    $credentials = $extractCredentials($dbConfigPath);
    if ($credentials === null) {
        continue;
    }

    $databaseUrl = sprintf(
        'mysql://%s:%s@%s:3306/%s?serverVersion=8.0.32&charset=utf8mb4',
        rawurlencode($credentials['username']),
        rawurlencode($credentials['password']),
        $credentials['host'],
        rawurlencode($credentials['dbname'])
    );

    $_SERVER['DATABASE_URL'] = $databaseUrl;
    $_ENV['DATABASE_URL'] = $databaseUrl;
    putenv('DATABASE_URL='.$databaseUrl);

    break;
}
