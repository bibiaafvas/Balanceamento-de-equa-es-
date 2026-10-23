<?php
/**
 * BalanceQ - Autenticação com Gmail (login.php)
 * Atende à regra de negócio CORE: Login obrigatório com conta Google/Gmail.
 */

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

// Tratamento de Logout
if (isset($_GET['logout'])) {
    logout();
    header('Location: index.php?msg=desconectado');
    exit;
}

// Se já estiver logado, redireciona para a página principal
if (isLoggedIn()) {
    header('Location: index.php');
    exit;
}

$error = null;
$emailInput = '';
$nomeInput = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $emailInput = trim($_POST['email'] ?? '');
    $nomeInput = trim($_POST['nome'] ?? '');

    try {
        if (empty($emailInput)) {
            throw new InvalidArgumentException("Por favor, informe seu endereço de e-mail do Gmail.");
        }
        
        $user = loginWithGmail($emailInput, $nomeInput);
        
        $redirect = $_GET['redirect'] ?? 'index.php';
        session_write_close();
        header("Location: {$redirect}");
        exit;
    } catch (Throwable $e) {
        $error = $e->getMessage();
    }
}

$pageTitle = 'Login com Gmail - BalanceQ';
require_once __DIR__ . '/components/header.php';
?>

<div class="min-h-[75vh] flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8 bg-white p-8 sm:p-10 rounded-3xl shadow-xl shadow-slate-200/60 border border-slate-100">
        
        <!-- Header do Card -->
        <div class="text-center">
            <div class="mx-auto w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-600 to-emerald-500 flex items-center justify-center text-white shadow-lg shadow-blue-500/20 mb-4">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                Acesse o BalanceQ
            </h2>
            <p class="mt-2 text-sm text-slate-600">
                O login com conta <strong class="text-slate-800">Gmail</strong> é obrigatório para acessar o histórico em tempo real e salvar suas equações favoritas.
            </p>
        </div>

        <?php if ($error): ?>
            <div class="rounded-xl bg-rose-50 border border-rose-200 p-4 text-sm text-rose-700 flex items-start gap-3">
                <svg class="w-5 h-5 text-rose-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <!-- Formulário de Login com Gmail -->
        <form class="mt-6 space-y-4" method="POST" action="login.php<?= isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : '' ?>">
            
            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    E-mail Google / Gmail <span class="text-rose-500">*</span>
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                        <svg class="w-5 h-5 text-slate-400" viewBox="0 0 24 24">
                            <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                            <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                            <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                            <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                        </svg>
                    </div>
                    <input 
                        id="email" 
                        name="email" 
                        type="email" 
                        required 
                        value="<?= htmlspecialchars($emailInput) ?>" 
                        placeholder="exemplo@gmail.com" 
                        pattern="^[a-zA-Z0-9._%+-]+@(gmail\.com|googlemail\.com)$"
                        title="O e-mail deve pertencer ao domínio @gmail.com"
                        class="block w-full pl-11 pr-3 py-3 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium transition-smooth"
                    >
                </div>
                <p class="text-[11px] text-slate-500 mt-1">É obrigatório utilizar terminação <strong>@gmail.com</strong>.</p>
            </div>

            <div>
                <label for="nome" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1">
                    Seu Nome (Opcional)
                </label>
                <input 
                    id="nome" 
                    name="nome" 
                    type="text" 
                    value="<?= htmlspecialchars($nomeInput) ?>" 
                    placeholder="Ex: Beatriz Vasconcelos" 
                    class="block w-full px-4 py-3 border border-slate-300 rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm font-medium transition-smooth"
                >
            </div>

            <button 
                type="submit" 
                class="w-full flex items-center justify-center gap-2 py-3.5 px-4 border border-transparent rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-600 hover:from-blue-700 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-md shadow-blue-500/20 transition-smooth"
            >
                <span>Entrar com Gmail</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
            </button>
        </form>

        <!-- Acesso Rápido para Avaliação e Demonstração -->
        <div class="pt-6 border-t border-slate-100">
            <p class="text-xs font-bold uppercase tracking-wider text-slate-400 text-center mb-3">
                Acesso Rápido para Teste
            </p>
            <div class="grid grid-cols-2 gap-2.5">
                <button 
                    type="button" 
                    onclick="fillQuickLogin('aluno.quimica@gmail.com', 'Aluno de Química')"
                    class="p-2.5 rounded-xl border border-slate-200 hover:border-blue-400 hover:bg-blue-50 text-left transition-smooth text-xs"
                >
                    <div class="font-bold text-slate-800">Aluno Demo</div>
                    <div class="text-[10px] text-slate-500 truncate">aluno.quimica@gmail.com</div>
                </button>
                <button 
                    type="button" 
                    onclick="fillQuickLogin('prof.lavoisier@gmail.com', 'Prof. Lavoisier')"
                    class="p-2.5 rounded-xl border border-slate-200 hover:border-emerald-400 hover:bg-emerald-50 text-left transition-smooth text-xs"
                >
                    <div class="font-bold text-slate-800">Professor Demo</div>
                    <div class="text-[10px] text-slate-500 truncate">prof.lavoisier@gmail.com</div>
                </button>
            </div>
        </div>

        <div class="text-center pt-2">
            <a href="index.php" class="text-xs font-semibold text-slate-500 hover:text-slate-800 transition-smooth">
                ← Voltar para o Balanceador
            </a>
        </div>
    </div>
</div>

<script>
    function fillQuickLogin(email, nome) {
        document.getElementById('email').value = email;
        document.getElementById('nome').value = nome;
        document.querySelector('form').submit();
    }
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
