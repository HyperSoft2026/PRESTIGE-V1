<?php
declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

function respond(int $status, array $payload): never
{
    http_response_code($status);
    echo json_encode($payload, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    exit;
}

function databaseConfig(): array
{
    $uri = getenv('MYSQL_ADDON_URI');

    if (is_string($uri) && $uri !== '') {
        $parts = parse_url($uri);

        if (!is_array($parts) || empty($parts['host']) || empty($parts['user']) || !isset($parts['path'])) {
            throw new RuntimeException('MYSQL_ADDON_URI is not a valid MySQL connection URI.');
        }

        return [
            'host' => $parts['host'],
            'port' => $parts['port'] ?? 3306,
            'database' => ltrim($parts['path'], '/'),
            'username' => rawurldecode($parts['user']),
            'password' => rawurldecode($parts['pass'] ?? ''),
        ];
    }

    $host = getenv('MYSQL_ADDON_HOST');
    $database = getenv('MYSQL_ADDON_DB');
    $username = getenv('MYSQL_ADDON_USER');
    $password = getenv('MYSQL_ADDON_PASSWORD');

    if (!$host || !$database || !$username) {
        throw new RuntimeException('MySQL connection environment variables are missing.');
    }

    return [
        'host' => $host,
        'port' => getenv('MYSQL_ADDON_PORT') ?: 3306,
        'database' => $database,
        'username' => $username,
        'password' => $password ?: '',
    ];
}

function checkDatabase(): bool
{
    $config = databaseConfig();
    $dsn = sprintf(
        'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
        $config['host'],
        $config['port'],
        $config['database']
    );

    $pdo = new PDO($dsn, $config['username'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 5,
        PDO::ATTR_EMULATE_PREPARES => false,
    ]);

    $pdo->query('SELECT 1');
    return true;
}

$path = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';

if ($method !== 'GET') {
    header('Allow: GET');
    respond(405, ['status' => 'error', 'message' => 'Method not allowed']);
}

if ($path === '/') {
    respond(200, [
        'name' => 'PRESTIGE V1',
        'service' => 'web-api',
        'stage' => 'foundation',
        'message' => 'PRESTIGE V1 service is running.',
    ]);
}

if ($path === '/health') {
    respond(200, ['status' => 'ok', 'service' => 'prestige-api']);
}

if ($path === '/health/db') {
    try {
        checkDatabase();
        respond(200, ['status' => 'ok', 'database' => 'connected']);
    } catch (Throwable $error) {
        error_log('PRESTIGE database health check failed: ' . $error->getMessage());
        respond(503, ['status' => 'error', 'database' => 'unavailable']);
    }
}

respond(404, ['status' => 'error', 'message' => 'Not found']);
