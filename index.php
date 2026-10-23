<?php
/**
 * BalanceQ - Página Principal e Balanceador Químico (index.php)
 */

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/balancer.php';

$pageTitle = 'BalanceQ - Balanceador Interativo de Equações Químicas';
$initialEquation = $_GET['eq'] ?? '';
$initialModo = $_GET['modo'] ?? 'automatico';

require_once __DIR__ . '/components/header.php';
?>

<!-- Hero Section -->
<section class="relative overflow-hidden bg-gradient-to-b from-blue-50/70 via-white to-slate-50 pt-8 pb-12 sm:pt-14 sm:pb-20 border-b border-slate-200/70">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center max-w-3xl mx-auto space-y-4 sm:space-y-6">
            
            <!-- Badges de Destaque -->
            <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-emerald-100/80 border border-emerald-200 text-emerald-800 text-xs sm:text-sm font-bold shadow-sm">
                <span class="flex h-2 w-2 rounded-full bg-emerald-500 animate-ping"></span>
                <span>Balanceamento Estequiométrico em Tempo Real</span>
            </div>

            <!-- Título Principal -->
            <h1 class="text-3xl sm:text-5xl lg:text-6xl font-black text-slate-900 tracking-tight leading-tight sm:leading-none">
                Equilíbrio Químico Simples, <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-600 bg-clip-text text-transparent">Rápido & Educativo</span>
            </h1>

            <!-- Subtítulo -->
            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed">
                Descubra os coeficientes corretos de qualquer reação química, preserve as fórmulas moleculares e aprenda o passo a passo com a Lei de Lavoisier e a Regra MACHO.
            </p>

            <!-- Ações do Hero -->
            <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
                <a href="#balanceador" class="px-6 py-3.5 rounded-2xl bg-gradient-to-r from-blue-600 to-emerald-600 hover:from-blue-700 hover:to-emerald-700 text-white font-bold text-sm sm:text-base shadow-lg shadow-blue-500/25 transition-smooth flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                    <span>Começar a Balancear</span>
                </a>
                <a href="exercicios.php" class="px-6 py-3.5 rounded-2xl bg-white hover:bg-slate-100 text-slate-700 font-bold text-sm sm:text-base border border-slate-200 shadow-sm transition-smooth flex items-center gap-2">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Praticar Exercícios</span>
                </a>
            </div>

            <!-- Recursos em destaque -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 pt-6 text-left max-w-2xl mx-auto">
                <div class="p-3 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                    <div class="text-blue-600 font-bold text-xs uppercase">Modo Duplo</div>
                    <div class="text-slate-800 text-xs font-semibold mt-0.5">Automático & Manual</div>
                </div>
                <div class="p-3 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                    <div class="text-emerald-600 font-bold text-xs uppercase">Regra MACHO</div>
                    <div class="text-slate-800 text-xs font-semibold mt-0.5">Passo a passo didático</div>
                </div>
                <div class="p-3 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                    <div class="text-indigo-600 font-bold text-xs uppercase">Login Gmail</div>
                    <div class="text-slate-800 text-xs font-semibold mt-0.5">Histórico & Salvos</div>
                </div>
                <div class="p-3 rounded-2xl bg-white border border-slate-200/80 shadow-sm">
                    <div class="text-amber-600 font-bold text-xs uppercase">100% Preciso</div>
                    <div class="text-slate-800 text-xs font-semibold mt-0.5">Álgebra Linear Exata</div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Seção Central do Balanceador -->
<section id="balanceador" class="py-10 sm:py-16 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-xl shadow-slate-200/50 overflow-hidden">
        
        <!-- Topo do Card do Balanceador -->
        <div class="bg-gradient-to-r from-slate-900 via-slate-800 to-blue-950 p-6 sm:p-8 text-white relative">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h2 class="text-xl sm:text-2xl font-black tracking-tight flex items-center gap-2">
                        <svg class="w-6 h-6 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        Calculadora Estequiométrica
                    </h2>
                    <p class="text-slate-300 text-xs sm:text-sm mt-1">
                        Digite a reação química ou escolha um dos modelos abaixo para balancear.
                    </p>
                </div>

                <!-- Seletor de Modo: Automático vs Manual (Regra de Negócio CORE) -->
                <div class="bg-slate-800/80 p-1.5 rounded-2xl border border-slate-700/80 inline-flex items-center">
                    <label class="cursor-pointer text-xs font-bold px-3 py-1.5 rounded-xl transition-smooth flex items-center gap-1.5 has-[:checked]:bg-blue-600 has-[:checked]:text-white text-slate-300 hover:text-white">
                        <input type="radio" name="modo" value="automatico" class="sr-only" <?= $initialModo === 'automatico' ? 'checked' : '' ?>>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        <span>Automático</span>
                    </label>
                    <label class="cursor-pointer text-xs font-bold px-3 py-1.5 rounded-xl transition-smooth flex items-center gap-1.5 has-[:checked]:bg-emerald-600 has-[:checked]:text-white text-slate-300 hover:text-white">
                        <input type="radio" name="modo" value="manual" class="sr-only" <?= $initialModo === 'manual' ? 'checked' : '' ?>>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        <span>Manual (Passo a Passo)</span>
                    </label>
                </div>
            </div>
        </div>

        <!-- Corpo do Formulário -->
        <div class="p-6 sm:p-8 space-y-6">

            <form id="balancerForm" class="space-y-4">
                <div>
                    <label for="equationInput" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                        Equação Química
                    </label>
                    <div class="relative">
                        <input 
                            type="text" 
                            id="equationInput" 
                            name="equation" 
                            value="<?= htmlspecialchars($initialEquation) ?>" 
                            placeholder="Exemplo: H2 + O2 -> H2O ou Fe + O2 = Fe2O3" 
                            autocomplete="off"
                            class="block w-full px-4 sm:px-5 py-4 border-2 border-slate-200 rounded-2xl text-slate-900 placeholder-slate-400 font-mono-chem text-base sm:text-xl font-bold focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-100 transition-smooth"
                        >
                        <button 
                            type="button" 
                            onclick="clearEquation()"
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-xs font-semibold text-slate-400 hover:text-rose-600 bg-slate-100 hover:bg-rose-50 px-2.5 py-1.5 rounded-lg transition-smooth"
                            title="Limpar campo de digitação"
                        >
                            Limpar
                        </button>
                    </div>
                </div>

                <!-- Teclado Químico Rápido (Subscritos e Símbolos) -->
                <div>
                    <div class="text-[11px] font-bold uppercase tracking-wider text-slate-400 mb-1.5 flex items-center justify-between">
                        <span>Teclado Químico Rápido (Índices & Símbolos)</span>
                        <span class="text-[10px] text-slate-400 lowercase font-normal">clique para inserir no cursor</span>
                    </div>
                    <div class="flex flex-wrap gap-1.5">
                        <!-- Subscritos -->
                        <?php foreach (['₀','₁','₂','₃','₄','₅','₆','₇','₈','₉'] as $sub): ?>
                            <button 
                                type="button" 
                                onclick="insertAtCursor('<?= $sub ?>')"
                                class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-blue-100 hover:text-blue-700 font-mono font-bold text-sm text-slate-700 border border-slate-200 transition-smooth"
                            ><?= $sub ?></button>
                        <?php endforeach; ?>
                        
                        <div class="w-px h-8 bg-slate-200 mx-1"></div>

                        <!-- Símbolos e delimitadores -->
                        <button type="button" onclick="insertAtCursor(' → ')" class="px-2.5 h-8 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-700 font-bold text-sm border border-blue-200 transition-smooth" title="Seta de reação">→</button>
                        <button type="button" onclick="insertAtCursor(' + ')" class="px-2.5 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm border border-slate-200 transition-smooth">+</button>
                        <button type="button" onclick="insertAtCursor('(')" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm border border-slate-200 transition-smooth">(</button>
                        <button type="button" onclick="insertAtCursor(')')" class="w-8 h-8 rounded-lg bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm border border-slate-200 transition-smooth">)</button>
                    </div>
                </div>

                <!-- Botões de Ação Principal -->
                <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 pt-2">
                    <button 
                        type="submit" 
                        id="submitBtn"
                        class="flex-1 py-4 px-6 rounded-2xl bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-600 hover:from-blue-700 hover:to-emerald-700 text-white font-black text-base shadow-lg shadow-blue-500/25 transition-smooth flex items-center justify-center gap-2 group"
                    >
                        <svg id="btnSpinner" class="hidden w-5 h-5 animate-spin text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                        <svg class="w-5 h-5 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                        <span id="btnText">Balancear Equação</span>
                    </button>
                    
                    <button 
                        type="button" 
                        onclick="clearEquation()"
                        class="py-4 px-6 rounded-2xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm transition-smooth"
                    >
                        Limpar Campos
                    </button>
                </div>
            </form>

            <!-- Reações Famosas de Exemplo para Teste -->
            <div class="pt-4 border-t border-slate-100">
                <span class="text-xs font-bold uppercase tracking-wider text-slate-400 block mb-2">Exemplos Prontos para Testar:</span>
                <div class="flex flex-wrap gap-2">
                    <button type="button" onclick="setEquationExample('H2 + O2 -> H2O')" class="px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-mono text-xs border border-slate-200 font-semibold transition-smooth">H₂ + O₂ → H₂O (Água)</button>
                    <button type="button" onclick="setEquationExample('CH4 + O2 -> CO2 + H2O')" class="px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-mono text-xs border border-slate-200 font-semibold transition-smooth">CH₄ + O₂ → CO₂ + H₂O (Metano)</button>
                    <button type="button" onclick="setEquationExample('Fe + O2 -> Fe2O3')" class="px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-mono text-xs border border-slate-200 font-semibold transition-smooth">Fe + O₂ → Fe₂O₃ (Ferro)</button>
                    <button type="button" onclick="setEquationExample('Al + HCl -> AlCl3 + H2')" class="px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-mono text-xs border border-slate-200 font-semibold transition-smooth">Al + HCl → AlCl₃ + H₂</button>
                    <button type="button" onclick="setEquationExample('Al2(SO4)3 + Ca(OH)2 -> Al(OH)3 + CaSO4')" class="px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-mono text-xs border border-slate-200 font-semibold transition-smooth">Al₂(SO₄)₃ + Ca(OH)₂ (Dupla Troca)</button>
                    <button type="button" onclick="setEquationExample('C6H12O6 + O2 -> CO2 + H2O')" class="px-3 py-1.5 rounded-xl bg-slate-50 hover:bg-blue-50 text-slate-700 hover:text-blue-700 font-mono text-xs border border-slate-200 font-semibold transition-smooth">C₆H₁₂O₆ + O₂ (Glicose)</button>
                </div>
            </div>

            <!-- Seção de Mensagem de Erro Científico -->
            <div id="errorSection" class="hidden rounded-2xl bg-rose-50 border-2 border-rose-200 p-5 space-y-2">
                <div class="flex items-center gap-2 text-rose-800 font-bold text-base">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    <span>Atenção: Não foi possível balancear a equação</span>
                </div>
                <p id="errorMessage" class="text-sm text-rose-700 leading-relaxed font-medium"></p>
                <div class="text-xs text-rose-600/90 pt-1">
                    Dica: Verifique se todas as fórmulas estão escritas corretamente (ex: <code class="bg-rose-100 px-1 rounded">H2O</code> e não <code class="bg-rose-100 px-1 rounded">h2o</code>) e se existe uma seta <code class="bg-rose-100 px-1 rounded">-></code> separando os reagentes dos produtos.
                </div>
            </div>

            <!-- Seção de Resultados -->
            <div id="resultSection" class="hidden space-y-6 pt-4 border-t border-slate-200">
                
                <!-- Card de Destaque da Equação Balanceada -->
                <div class="p-6 sm:p-8 rounded-3xl bg-gradient-to-br from-emerald-50 via-teal-50/40 to-blue-50 border-2 border-emerald-200/90 shadow-md">
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
                        <span class="inline-flex items-center gap-1.5 text-xs font-bold uppercase tracking-wider text-emerald-800 bg-emerald-100 px-3 py-1 rounded-full">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Equação Balanceada com Sucesso
                        </span>

                        <!-- Ações do Resultado: Copiar, Salvar, Refazer -->
                        <div class="flex items-center gap-2">
                            <button 
                                type="button" 
                                onclick="copyText(document.getElementById('balancedEquationPlain').value)"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs border border-slate-200 shadow-sm transition-smooth"
                                title="Copiar equação balanceada"
                            >
                                <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                <span>Copiar</span>
                            </button>

                            <button 
                                type="button" 
                                id="saveEquationBtn"
                                onclick="toggleSaveHistory(this.dataset.historyId, this)"
                                class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-white hover:bg-amber-50 text-slate-700 font-semibold text-xs border border-slate-200 shadow-sm transition-smooth"
                                title="Salvar equação nos favoritos"
                            >
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                                <span>Salvar Equação</span>
                            </button>
                        </div>
                    </div>

                    <!-- Equação Antes vs Depois -->
                    <div class="space-y-4">
                        <div>
                            <div class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-1">Antes do Balanceamento:</div>
                            <div id="beforeEquation" class="font-mono-chem text-base sm:text-lg text-slate-600 bg-white/70 p-3 rounded-xl border border-slate-200/80"></div>
                        </div>

                        <div>
                            <div class="text-xs font-bold uppercase tracking-wider text-emerald-800 mb-1 flex items-center justify-between">
                                <span>Depois do Balanceamento (Coeficientes Estequiométricos):</span>
                                <span class="text-[10px] text-emerald-600 font-normal">números destacados indicam os coeficientes</span>
                            </div>
                            <div id="balancedEquationHtml" class="font-mono-chem text-lg sm:text-2xl text-slate-900 bg-white p-4 sm:p-5 rounded-2xl border-2 border-emerald-300 shadow-sm overflow-x-auto whitespace-nowrap"></div>
                            <input type="hidden" id="balancedEquationPlain" value="">
                        </div>
                    </div>

                </div>

                <!-- Tabela de Balanço de Átomos (Lavoisier) -->
                <div class="bg-white rounded-3xl border border-slate-200/80 p-5 sm:p-6 space-y-4 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="font-bold text-slate-900 text-base">Comprovação do Balanço Atômico</h3>
                            <p class="text-xs text-slate-500">Número de átomos antes e depois da reação química</p>
                        </div>
                        <span class="text-xs font-semibold px-2.5 py-1 rounded-lg bg-blue-50 text-blue-700">Lei de Lavoisier</span>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead>
                                <tr class="border-b border-slate-200 text-xs font-bold uppercase tracking-wider text-slate-400">
                                    <th class="py-2.5 px-4">Elemento Químico</th>
                                    <th class="py-2.5 px-4 text-center">Átomos nos Reagentes</th>
                                    <th class="py-2.5 px-4 text-center">Átomos nos Produtos</th>
                                    <th class="py-2.5 px-4 text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody id="atomsTableBody"></tbody>
                        </table>
                    </div>
                </div>

                <!-- Seção Passo a Passo Pedagógico (Ativa no Modo Manual) -->
                <div id="stepByStepCard" class="hidden space-y-4">
                    <div class="bg-gradient-to-r from-emerald-600 to-teal-700 p-5 rounded-3xl text-white shadow-md">
                        <div class="flex items-center gap-2">
                            <svg class="w-6 h-6 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            <h3 class="font-extrabold text-lg sm:text-xl">Resolução Passo a Passo (Modo Manual)</h3>
                        </div>
                        <p class="text-xs sm:text-sm text-emerald-100 mt-1">
                            Aprenda a sequência lógica e a metodologia estequiométrica utilizada para chegar aos coeficientes finais.
                        </p>
                    </div>

                    <div id="stepsContainer" class="space-y-3"></div>
                </div>

            </div>

        </div>

    </div>

</section>

<!-- Seção Informativa Rápida (Estudos & Metodologia) -->
<section class="py-12 bg-slate-100/70 border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-10">
            <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">Como Dominar o Balanceamento Químico</h2>
            <p class="text-sm text-slate-600 mt-2">Dicas essenciais para o seu estudo no Ensino Médio e cursos técnicos.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card 1 -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold">1</div>
                <h3 class="font-bold text-slate-900 text-lg">Nunca altere os índices</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Os números pequenos na fórmula química (como o 2 em <code class="bg-slate-100 px-1 rounded">H₂O</code>) definem a substância. Modificar o índice muda a matéria! Apenas altere os <strong>coeficientes estequiométricos</strong> antes da fórmula.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold">2</div>
                <h3 class="font-bold text-slate-900 text-lg">Aplique a Regra MACHO</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    Comece balanceando os <strong>M</strong>etais, depois os <strong>A</strong>metais, o <strong>C</strong>arbono, o <strong>H</strong>idrogênio e, por fim, o <strong>O</strong>xigênio. Essa ordem reduz em mais de 90% os retrabalhos!
                </p>
            </div>

            <!-- Card 3 -->
            <div class="bg-white p-6 rounded-3xl border border-slate-200/80 shadow-sm space-y-3">
                <div class="w-10 h-10 rounded-2xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold">3</div>
                <h3 class="font-bold text-slate-900 text-lg">Conserve a Massa</h3>
                <p class="text-sm text-slate-600 leading-relaxed">
                    O número total de átomos de cada elemento deve ser exatamente idêntico antes e depois da reação, respeitando a célebre Lei da Conservação das Massas de Antoine Lavoisier.
                </p>
            </div>
        </div>
    </div>
</section>

<?php if (!empty($initialEquation)): ?>
<script>
    // Se a página foi carregada com parâmetro ?eq=... dispara automaticamente o balanceamento
    window.addEventListener('DOMContentLoaded', () => {
        document.getElementById('balancerForm')?.dispatchEvent(new Event('submit'));
    });
</script>
<?php endif; ?>

<?php require_once __DIR__ . '/components/footer.php'; ?>
