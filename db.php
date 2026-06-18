<?php
require_once __DIR__ . '/config.php';

/**
 * Returns a PDO connection instance.
 * Falls back gracefully or throws PDOException.
 */
function getDbConnection() {
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    try {
        return new PDO($dsn, DB_USER, DB_PASS, $options);
    } catch (\PDOException $e) {
        // For API and dev robustness, throw exception to be caught in api.php or index.php
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}
?>
