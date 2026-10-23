-- ==========================================================
-- Banco de Dados: BalanceQ
-- Aplicação de Balanceamento de Equações Químicas
-- ==========================================================

CREATE DATABASE IF NOT EXISTS `balanceq` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `balanceq`;

-- Tabela de Usuários (Login obrigatório com Gmail)
CREATE TABLE IF NOT EXISTS `usuarios` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `nome` VARCHAR(100) NOT NULL,
    `email` VARCHAR(190) NOT NULL UNIQUE,
    `foto` VARCHAR(255) DEFAULT NULL,
    `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Histórico e Equações Salvas
CREATE TABLE IF NOT EXISTS `historico` (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `usuario_id` INT NOT NULL,
    `equacao_original` VARCHAR(255) NOT NULL,
    `equacao_balanceada` VARCHAR(255) NOT NULL,
    `modo` ENUM('automatico', 'manual') DEFAULT 'automatico',
    `detalhes_json` LONGTEXT NULL,
    `salvo` TINYINT(1) DEFAULT 0,
    `criado_em` DATETIME DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT `fk_historico_usuario` FOREIGN KEY (`usuario_id`) 
        REFERENCES `usuarios` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Índices para otimização de consultas
CREATE INDEX `idx_historico_usuario` ON `historico` (`usuario_id`, `criado_em`);
CREATE INDEX `idx_historico_salvo` ON `historico` (`usuario_id`, `salvo`);
