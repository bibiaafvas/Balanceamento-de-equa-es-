<?php
/**
 * BalanceQ - Módulo de Conexão com o Banco de Dados (bd.php)
 * Gerencia a conexão segura via PDO e previne SQL Injection.
 */

declare(strict_types=1);

// Configurações do MySQL
define('DB_HOST', getenv('DB_HOST') ?: '127.0.0.1');
define('DB_PORT', getenv('DB_PORT') ?: '3306');
define('DB_NAME', getenv('DB_NAME') ?: 'balanceq');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');

if (!function_exists('getPDO')) {
    /**
     * Retorna a instância única do PDO (Singleton Pattern)
     */
    function getPDO(): PDO {
        static $pdo = null;

        if ($pdo !== null) {
            return $pdo;
        }

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            // Tenta conectar ao MySQL
            $dsn = sprintf('mysql:host=%s;port=%s;charset=utf8mb4', DB_HOST, DB_PORT);
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            
            // Garante a existência do banco no MySQL
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
            $pdo->exec("USE `" . DB_NAME . "`");
            
            initializeTables($pdo, 'mysql');
            return $pdo;
        } catch (PDOException $e) {
            // Fallback para SQLite local caso o servidor MySQL não esteja ativo no momento
            $sqliteFile = __DIR__ . '/balanceq.sqlite';
            $pdo = new PDO('sqlite:' . $sqliteFile, null, null, $options);
            $pdo->exec('PRAGMA foreign_keys = ON;');
            initializeTables($pdo, 'sqlite');
            return $pdo;
        }
    }
}

if (!function_exists('initializeTables')) {
    /**
     * Inicializa a estrutura das tabelas de forma automática caso ainda não existam.
     */
    function initializeTables(PDO $pdo, string $driver = 'mysql'): void {
        if ($driver === 'mysql') {
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS `usuarios` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `nome` VARCHAR(100) NOT NULL,
                    `email` VARCHAR(190) NOT NULL UNIQUE,
                    `foto` VARCHAR(255) DEFAULT NULL,
                    `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

                CREATE TABLE IF NOT EXISTS `historico` (
                    `id` INT AUTO_INCREMENT PRIMARY KEY,
                    `usuario_id` INT NOT NULL,
                    `equacao_original` VARCHAR(255) NOT NULL,
                    `equacao_balanceada` VARCHAR(255) NOT NULL,
                    `modo` VARCHAR(20) DEFAULT 'automatico',
                    `detalhes_json` LONGTEXT NULL,
                    `salvo` TINYINT(1) DEFAULT 0,
                    `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    CONSTRAINT `fk_historico_usuario` FOREIGN KEY (`usuario_id`) 
                        REFERENCES `usuarios` (`id`) ON DELETE CASCADE
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
            ");
        } else {
            // Dialeto SQLite
            $pdo->exec("
                CREATE TABLE IF NOT EXISTS `usuarios` (
                    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
                    `nome` TEXT NOT NULL,
                    `email` TEXT NOT NULL UNIQUE,
                    `foto` TEXT DEFAULT NULL,
                    `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP
                );

                CREATE TABLE IF NOT EXISTS `historico` (
                    `id` INTEGER PRIMARY KEY AUTOINCREMENT,
                    `usuario_id` INTEGER NOT NULL,
                    `equacao_original` TEXT NOT NULL,
                    `equacao_balanceada` TEXT NOT NULL,
                    `modo` TEXT DEFAULT 'automatico',
                    `detalhes_json` TEXT NULL,
                    `salvo` INTEGER DEFAULT 0,
                    `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP,
                    FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`) ON DELETE CASCADE
                );
            ");
        }
    }
}

// Inicializa a conexão padrão disponível globalmente
$db = getPDO();
