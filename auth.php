<?php
/**
 * BalanceQ - Módulo de Autenticação (auth.php)
 * Gerencia a sessão nativa do PHP e o login obrigatório com conta Google/Gmail.
 */

declare(strict_types=1);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . '/bd.php';

/**
 * Verifica se um e-mail é de domínio Gmail válido
 */
function isValidGmail(string $email): bool {
    $email = trim(strtolower($email));
    return (bool) preg_match('/^[a-z0-9._%+-]+@(gmail\.com|googlemail\.com)$/i', $email);
}

/**
 * Retorna o usuário logado atualmente na sessão ou null
 */
function getCurrentUser(): ?array {
    return $_SESSION['balanceq_user'] ?? null;
}

/**
 * Retorna true se houver um usuário autenticado
 */
function isLoggedIn(): bool {
    return !empty($_SESSION['balanceq_user']['id']);
}

/**
 * Força autenticação. Redireciona para login.php se não for API, ou retorna JSON 401.
 */
function requireLogin(bool $isApi = false): array {
    $user = getCurrentUser();
    if (!$user) {
        if ($isApi) {
            header('Content-Type: application/json; charset=utf-8');
            http_response_code(401);
            echo json_encode([
                'success' => false,
                'message' => 'É obrigatório fazer login com uma conta Gmail para realizar esta ação.'
            ], JSON_UNESCAPED_UNICODE);
            exit;
        } else {
            header('Location: login.php');
            exit;
        }
    }
    return $user;
}

/**
 * Realiza o login ou cadastro automático do usuário via Gmail
 */
function loginWithGmail(string $email, ?string $nome = null): array {
    $email = trim(strtolower($email));
    
    if (!isValidGmail($email)) {
        throw new InvalidArgumentException("O e-mail deve ser um endereço oficial do Gmail (@gmail.com).");
    }

    if (empty($nome)) {
        // Extrai o nome amigável a partir do prefixo do email
        $prefix = explode('@', $email)[0];
        $nome = ucwords(str_replace(['.', '_', '-'], ' ', $prefix));
    }

    $pdo = getPDO();

    // Busca usuário existente
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email LIMIT 1");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if (!$user) {
        // Cadastra novo usuário
        $avatarSeed = urlencode($nome);
        $foto = "https://api.dicebear.com/7.x/initials/svg?seed={$avatarSeed}&backgroundColor=2563eb,10b981";
        
        $insert = $pdo->prepare("INSERT INTO usuarios (nome, email, foto, criado_em) VALUES (:nome, :email, :foto, :criado_em)");
        $now = date('Y-m-d H:i:s');
        $insert->execute([
            ':nome' => $nome,
            ':email' => $email,
            ':foto' => $foto,
            ':criado_em' => $now
        ]);
        
        $userId = (int) $pdo->lastInsertId();
        $user = [
            'id' => $userId,
            'nome' => $nome,
            'email' => $email,
            'foto' => $foto,
            'criado_em' => $now
        ];
    }

    // Registra na sessão nativa do PHP
    $_SESSION['balanceq_user'] = $user;
    return $user;
}

/**
 * Encerra a sessão do usuário
 */
function logout(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    unset($_SESSION['balanceq_user']);
    session_destroy();
}
