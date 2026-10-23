<?php
/**
 * BalanceQ - API Controller (api.php)
 * Processa requisições assíncronas de balanceamento, histórico, favoritos e exercícios.
 */

declare(strict_types=1);

header('Content-Type: application/json; charset=utf-8');

require_once __DIR__ . '/bd.php';
require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/balancer.php';

// Leitura do corpo da requisição (JSON ou POST tradicional)
$rawBody = file_get_contents('php://input');
$data = [];
if (!empty($rawBody)) {
    $decoded = json_decode($rawBody, true);
    if (is_array($decoded)) {
        $data = $decoded;
    }
}
if (empty($data)) {
    $data = $_POST;
}

$action = $data['action'] ?? $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'balance':
            $equation = trim($data['equation'] ?? '');
            $modo = ($data['modo'] ?? 'automatico') === 'manual' ? 'manual' : 'automatico';

            if (empty($equation)) {
                throw new InvalidArgumentException("Por favor, digite uma equação química.");
            }

            // Realiza o balanceamento estequiométrico
            $result = balanceChemicalEquation($equation, $modo);

            // Se o usuário estiver autenticado com Gmail, registra no histórico
            $historyId = null;
            $user = getCurrentUser();
            if ($user) {
                $pdo = getPDO();
                $stmt = $pdo->prepare("
                    INSERT INTO historico (usuario_id, equacao_original, equacao_balanceada, modo, detalhes_json, salvo, criado_em)
                    VALUES (:uid, :orig, :bal, :modo, :json, 0, :created)
                ");
                $now = date('Y-m-d H:i:s');
                $stmt->execute([
                    ':uid' => $user['id'],
                    ':orig' => $result['original'],
                    ':bal' => $result['balanced_str'],
                    ':modo' => $modo,
                    ':json' => json_encode($result, JSON_UNESCAPED_UNICODE),
                    ':created' => $now
                ]);
                $historyId = (int) $pdo->lastInsertId();
            }

            $result['history_id'] = $historyId;
            $result['user_logged_in'] = ($user !== null);

            session_write_close();
            echo json_encode($result, JSON_UNESCAPED_UNICODE);
            break;

        case 'toggle_save':
            $user = requireLogin(true);
            $historyId = (int) ($data['id'] ?? 0);

            if ($historyId <= 0) {
                throw new InvalidArgumentException("ID de histórico inválido.");
            }

            $pdo = getPDO();
            // Verifica o item atual
            $stmt = $pdo->prepare("SELECT salvo FROM historico WHERE id = :id AND usuario_id = :uid LIMIT 1");
            $stmt->execute([':id' => $historyId, ':uid' => $user['id']]);
            $item = $stmt->fetch();

            if (!$item) {
                throw new Exception("Registro não encontrado ou você não tem permissão para modificá-lo.");
            }

            $newSalvo = $item['salvo'] ? 0 : 1;
            $update = $pdo->prepare("UPDATE historico SET salvo = :salvo WHERE id = :id AND usuario_id = :uid");
            $update->execute([':salvo' => $newSalvo, ':id' => $historyId, ':uid' => $user['id']]);

            echo json_encode([
                'success' => true,
                'salvo' => (bool) $newSalvo,
                'message' => $newSalvo ? 'Equação salva nos favoritos!' : 'Equação removida dos favoritos.'
            ], JSON_UNESCAPED_UNICODE);
            break;

        case 'delete_history':
            $user = requireLogin(true);
            $historyId = (int) ($data['id'] ?? 0);

            if ($historyId <= 0) {
                throw new InvalidArgumentException("ID inválido.");
            }

            $pdo = getPDO();
            $stmt = $pdo->prepare("DELETE FROM historico WHERE id = :id AND usuario_id = :uid");
            $stmt->execute([':id' => $historyId, ':uid' => $user['id']]);

            echo json_encode([
                'success' => true,
                'message' => 'Item excluído com sucesso.'
            ], JSON_UNESCAPED_UNICODE);
            break;

        case 'clear_history':
            $user = requireLogin(true);
            $pdo = getPDO();
            // Limpa o histórico que não está favoritado
            $stmt = $pdo->prepare("DELETE FROM historico WHERE usuario_id = :uid AND salvo = 0");
            $stmt->execute([':uid' => $user['id']]);

            echo json_encode([
                'success' => true,
                'message' => 'Histórico recente limpo com sucesso! Suas equações salvas como favoritas foram preservadas.'
            ], JSON_UNESCAPED_UNICODE);
            break;

        case 'verify_exercise':
            $equation = trim($data['equation'] ?? '');
            $userRCoeffs = array_map('intval', $data['reactant_coeffs'] ?? []);
            $userPCoeffs = array_map('intval', $data['product_coeffs'] ?? []);

            if (empty($equation) || empty($userRCoeffs) || empty($userPCoeffs)) {
                throw new InvalidArgumentException("Dados incompletos para validação do exercício.");
            }

            $correct = balanceChemicalEquation($equation);
            $isCorrect = ($userRCoeffs === $correct['reactant_coeffs'] && $userPCoeffs === $correct['product_coeffs']);

            echo json_encode([
                'success' => true,
                'correct' => $isCorrect,
                'expected_reactant_coeffs' => $correct['reactant_coeffs'],
                'expected_product_coeffs' => $correct['product_coeffs'],
                'balanced_str' => $correct['balanced_str'],
                'message' => $isCorrect 
                    ? '🎉 Parabéns! Você acertou todos os coeficientes estequiométricos com precisão científica!'
                    : 'Ainda não está balanceado corretamente. Verifique se o número de átomos de cada elemento está igual nos dois lados!'
            ], JSON_UNESCAPED_UNICODE);
            break;

        default:
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => "Ação desconhecida: '$action'"
            ], JSON_UNESCAPED_UNICODE);
            break;
    }
} catch (Throwable $e) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ], JSON_UNESCAPED_UNICODE);
}
