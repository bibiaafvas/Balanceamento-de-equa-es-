<?php
/**
 * BalanceQ - Histórico e Equações Salvas (historico.php)
 * Atende ao requisito diferencial: Histórico de balanceamentos anteriores e equações salvas.
 */

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/bd.php';

$pageTitle = 'Histórico & Equações Salvas - BalanceQ';
$currentUser = getCurrentUser();

$historyItems = [];
$favoriteItems = [];

if ($currentUser) {
    $pdo = getPDO();
    $stmt = $pdo->prepare("
        SELECT * FROM historico 
        WHERE usuario_id = :uid 
        ORDER BY criado_em DESC
    ");
    $stmt->execute([':uid' => $currentUser['id']]);
    $historyItems = $stmt->fetchAll();

    foreach ($historyItems as $item) {
        if (!empty($item['salvo'])) {
            $favoriteItems[] = $item;
        }
    }
}

require_once __DIR__ . '/components/header.php';
?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <!-- Cabeçalho da Página -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-blue-100/80 text-blue-800 text-xs font-bold mb-2">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <span>Registro em Nuvem</span>
            </div>
            <h1 class="text-2xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Histórico de Balanceamentos</h1>
            <p class="text-sm sm:text-base text-slate-600 mt-1">Acompanhe suas consultas recentes e acesse equações salvas como favoritas.</p>
        </div>

        <?php if ($currentUser && !empty($historyItems)): ?>
            <button 
                type="button" 
                onclick="clearAllHistory()"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-rose-200 text-rose-700 hover:bg-rose-50 text-xs font-bold transition-smooth"
            >
                <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                <span>Limpar Histórico Recente</span>
            </button>
        <?php endif; ?>
    </div>

    <?php if (!$currentUser): ?>
        <!-- Banner para usuário não logado -->
        <div class="bg-white rounded-3xl border border-slate-200 p-8 sm:p-12 text-center max-w-xl mx-auto shadow-sm space-y-4">
            <div class="w-16 h-16 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center mx-auto shadow-sm">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h2 class="text-2xl font-bold text-slate-900">Login com Gmail Obrigatório</h2>
            <p class="text-sm text-slate-600 leading-relaxed">
                De acordo com as diretrizes do sistema, é obrigatório conectar-se com uma conta Google/Gmail para sincronizar seus balanceamentos anteriores e salvar equações favoritas.
            </p>
            <div class="pt-2">
                <a href="login.php?redirect=historico.php" class="inline-flex items-center gap-2 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold text-sm shadow-md shadow-blue-500/25 transition-smooth">
                    <span>Entrar com Gmail</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </a>
            </div>
        </div>

    <?php else: ?>

        <!-- Abas de Navegação: Todos vs Favoritos -->
        <div class="flex items-center gap-2 border-b border-slate-200 mb-6">
            <button 
                type="button" 
                id="tabAllBtn"
                onclick="switchHistoryTab('all')" 
                class="px-4 py-2.5 border-b-2 border-blue-600 text-blue-700 font-bold text-sm flex items-center gap-2 transition-smooth"
            >
                <span>Todas as Consultas</span>
                <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 text-xs font-mono font-semibold"><?= count($historyItems) ?></span>
            </button>
            <button 
                type="button" 
                id="tabFavBtn"
                onclick="switchHistoryTab('fav')" 
                class="px-4 py-2.5 border-b-2 border-transparent text-slate-500 hover:text-slate-800 font-bold text-sm flex items-center gap-2 transition-smooth"
            >
                <span class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-amber-500 fill-amber-500" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
                    <span>Equações Salvas</span>
                </span>
                <span class="px-2 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs font-mono font-semibold"><?= count($favoriteItems) ?></span>
            </button>
        </div>

        <?php if (empty($historyItems)): ?>
            <!-- Estado Vazio -->
            <div class="bg-white rounded-3xl border border-slate-200 p-10 text-center space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mx-auto">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                </div>
                <h3 class="font-bold text-slate-800 text-lg">Nenhum balanceamento registrado ainda</h3>
                <p class="text-sm text-slate-500 max-w-sm mx-auto">
                    Quando você balancear qualquer equação no modo automático ou manual, ela será registrada aqui automaticamente.
                </p>
                <div class="pt-2">
                    <a href="index.php" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-xs transition-smooth">
                        Ir para o Balanceador
                    </a>
                </div>
            </div>
        <?php else: ?>

            <!-- Lista de Itens do Histórico -->
            <div id="historyList" class="space-y-4">
                <?php foreach ($historyItems as $row): 
                    $isFav = (bool) $row['salvo'];
                    $dateFormatted = date('d/m/Y \à\s H:i', strtotime($row['criado_em']));
                ?>
                    <div 
                        id="history-row-<?= $row['id'] ?>" 
                        data-favorite="<?= $isFav ? '1' : '0' ?>"
                        class="history-card bg-white p-5 sm:p-6 rounded-2xl border border-slate-200/90 shadow-sm hover:shadow-md transition-smooth flex flex-col sm:flex-row sm:items-center justify-between gap-4"
                    >
                        <div class="space-y-2 flex-1">
                            <div class="flex items-center gap-2">
                                <span class="px-2.5 py-0.5 rounded-md text-[11px] font-bold uppercase tracking-wider <?= $row['modo'] === 'manual' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' ?>">
                                    <?= $row['modo'] === 'manual' ? 'Modo Manual (Passo a Passo)' : 'Modo Automático' ?>
                                </span>
                                <span class="text-xs text-slate-400 font-medium"><?= $dateFormatted ?></span>
                            </div>

                            <!-- Comparativo de equações -->
                            <div>
                                <div class="text-xs text-slate-400 font-mono">Original: <?= htmlspecialchars($row['equacao_original']) ?></div>
                                <div class="text-lg sm:text-xl font-bold font-mono-chem text-slate-900 mt-0.5">
                                    <?= htmlspecialchars($row['equacao_balanceada']) ?>
                                </div>
                            </div>
                        </div>

                        <!-- Botões de Ação -->
                        <div class="flex items-center gap-2 shrink-0 border-t sm:border-t-0 pt-3 sm:pt-0 border-slate-100">
                            <!-- Botão Favoritar / Salvar -->
                            <button 
                                type="button" 
                                onclick="toggleSaveHistory(<?= $row['id'] ?>, this)"
                                class="p-2.5 rounded-xl border border-slate-200 hover:bg-amber-50 text-slate-600 hover:text-amber-600 transition-smooth"
                                title="<?= $isFav ? 'Remover dos favoritos' : 'Salvar equação nos favoritos' ?>"
                            >
                                <svg class="star-icon w-5 h-5 <?= $isFav ? 'fill-amber-400 text-amber-400' : 'text-slate-300' ?>" viewBox="0 0 24 24">
                                    <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                </svg>
                            </button>

                            <!-- Copiar -->
                            <button 
                                type="button" 
                                onclick="copyText('<?= htmlspecialchars($row['equacao_balanceada'], ENT_QUOTES) ?>')"
                                class="p-2.5 rounded-xl border border-slate-200 hover:bg-slate-100 text-slate-600 transition-smooth"
                                title="Copiar equação"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </button>

                            <!-- Balancear Novamente -->
                            <a 
                                href="index.php?eq=<?= urlencode($row['equacao_original']) ?>&modo=<?= urlencode($row['modo']) ?>"
                                class="inline-flex items-center gap-1.5 px-3 py-2 rounded-xl bg-blue-50 hover:bg-blue-100 text-blue-700 text-xs font-bold transition-smooth"
                                title="Recarregar no balanceador"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                                <span>Ver Detalhes</span>
                            </a>

                            <!-- Excluir -->
                            <button 
                                type="button" 
                                onclick="deleteHistoryItem(<?= $row['id'] ?>)"
                                class="p-2.5 rounded-xl border border-slate-200 hover:bg-rose-50 hover:border-rose-200 text-slate-400 hover:text-rose-600 transition-smooth"
                                title="Excluir do histórico"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>

    <?php endif; ?>

</div>

<script>
    function switchHistoryTab(tab) {
        const tabAllBtn = document.getElementById('tabAllBtn');
        const tabFavBtn = document.getElementById('tabFavBtn');
        const cards = document.querySelectorAll('.history-card');

        if (tab === 'fav') {
            tabFavBtn.classList.add('border-blue-600', 'text-blue-700');
            tabFavBtn.classList.remove('border-transparent', 'text-slate-500');
            tabAllBtn.classList.remove('border-blue-600', 'text-blue-700');
            tabAllBtn.classList.add('border-transparent', 'text-slate-500');

            cards.forEach(card => {
                if (card.dataset.favorite === '1') {
                    card.classList.remove('hidden');
                } else {
                    card.classList.add('hidden');
                }
            });
        } else {
            tabAllBtn.classList.add('border-blue-600', 'text-blue-700');
            tabAllBtn.classList.remove('border-transparent', 'text-slate-500');
            tabFavBtn.classList.remove('border-blue-600', 'text-blue-700');
            tabFavBtn.classList.add('border-transparent', 'text-slate-500');

            cards.forEach(card => card.classList.remove('hidden'));
        }
    }
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
