<?php

/**
 * Load DB credentials from /include/db.php (outside web root) when present,
 * then expose DATABASE_URL for Symfony/Doctrine.
 */
$serverDbConfigCandidates = [
    '/include/db.php',
    dirname(__DIR__, 2).'/include/db.php',
    dirname(__DIR__, 3).'/include/db.php',
];

foreach ($serverDbConfigCandidates as $dbConfigPath) {
    if (!is_file($dbConfigPath) || !is_readable($dbConfigPath)) {
        continue;
    }

    $host = $dbname = $username = $password = null;
    require $dbConfigPath;

    if (!isset($host, $dbname, $username, $password)) {
        continue;
    }

    $databaseUrl = sprintf(
        'mysql://%s:%s@%s:3306/%s?serverVersion=8.0.32&charset=utf8mb4',
        rawurlencode((string) $username),
        rawurlencode((string) $password),
        (string) $host,
        rawurlencode((string) $dbname)
    );

    $_SERVER['DATABASE_URL'] = $databaseUrl;
    $_ENV['DATABASE_URL'] = $databaseUrl;
    putenv('DATABASE_URL='.$databaseUrl);

    break;
}
