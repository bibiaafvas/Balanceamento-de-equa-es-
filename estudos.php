<?php
/**
 * BalanceQ - Guia Completo de Estudos em Química (estudos.php)
 * Conceitos: Equações químicas, Conservação de Massas (Lavoisier),
 * Reagentes, Produtos, Coeficientes e a Regra MACHO.
 */

declare(strict_types=1);

require_once __DIR__ . '/auth.php';

$pageTitle = 'Guia de Estudos: Balanceamento Químico & Lavoisier - BalanceQ';
require_once __DIR__ . '/components/header.php';
?>

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-14 space-y-12">
    
    <!-- Hero / Introdução -->
    <div class="text-center max-w-3xl mx-auto space-y-4">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-indigo-100 text-indigo-800 text-xs font-bold">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            <span>Material Didático para Ensino Médio e Técnico</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">Fundamentos do Balanceamento Químico</h1>
        <p class="text-base sm:text-lg text-slate-600 leading-relaxed">
            Entenda por que balancear equações é indispensável na química e como utilizar a regra mais consagrada da estequiometria.
        </p>
    </div>

    <!-- Módulo 1: O que é uma Equação Química? -->
    <section class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200/90 shadow-sm space-y-4">
        <div class="flex items-center gap-3">
            <span class="w-10 h-10 rounded-2xl bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-lg">01</span>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900">O que é uma Equação Química?</h2>
        </div>
        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
            Uma <strong>equação química</strong> é a representação gráfica e simbólica de uma <strong>reação química</strong>. Nela, ligações químicas entre átomos são rompidas e novas ligações são formadas, transformando as substâncias iniciais em novas substâncias.
        </p>
        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-center font-mono-chem text-lg font-bold text-slate-800">
            <span class="text-blue-600">Reagentes</span> <span class="text-slate-400 font-sans mx-2">→</span> <span class="text-emerald-600">Produtos</span>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
            <div class="p-4 rounded-2xl bg-blue-50/70 border border-blue-100">
                <h3 class="font-bold text-blue-900 text-sm mb-1">Reagentes</h3>
                <p class="text-xs text-blue-800 leading-relaxed">
                    Ficam à esquerda da seta. São as substâncias que interagem e iniciam a reação (ex: <code class="bg-blue-100 px-1 rounded">H₂ + O₂</code>).
                </p>
            </div>
            <div class="p-4 rounded-2xl bg-emerald-50/70 border border-emerald-100">
                <h3 class="font-bold text-emerald-900 text-sm mb-1">Produtos</h3>
                <p class="text-xs text-emerald-800 leading-relaxed">
                    Ficam à direita da seta. São as substâncias formadas após a ocorrência da transformação química (ex: <code class="bg-emerald-100 px-1 rounded">H₂O</code>).
                </p>
            </div>
        </div>
    </section>

    <!-- Módulo 2: Princípio da Conservação da Massa (Lei de Lavoisier) -->
    <section class="bg-gradient-to-br from-slate-900 via-slate-800 to-blue-950 text-white p-6 sm:p-10 rounded-3xl shadow-xl space-y-6">
        <div class="flex items-center gap-3">
            <span class="w-10 h-10 rounded-2xl bg-emerald-500 text-slate-900 flex items-center justify-center font-bold text-lg">02</span>
            <div>
                <h2 class="text-xl sm:text-2xl font-black">A Lei de Lavoisier (Conservação das Massas)</h2>
                <span class="text-xs text-emerald-400 font-semibold">Base Científica da Estequiometria</span>
            </div>
        </div>

        <blockquote class="p-4 sm:p-6 rounded-2xl bg-white/10 border-l-4 border-emerald-400 italic text-base sm:text-lg text-slate-200">
            "Num recipiente fechado, a massa total antes da reação é sempre igual à massa total após a reação. Em outras palavras: na natureza, nada se cria, nada se perde, tudo se transforma."
            <footer class="text-xs text-emerald-300 font-bold not-italic mt-2">— Antoine Laurent de Lavoisier (1743–1794)</footer>
        </blockquote>

        <p class="text-sm sm:text-base text-slate-300 leading-relaxed">
            Átomos não podem ser criados do nada nem destruídos em reações químicas comuns. Portanto, <strong>o número total de átomos de cada elemento deve ser exatamente igual</strong> no lado dos reagentes e no lado dos produtos. Balancear é garantir essa igualdade matemática e física!
        </p>
    </section>

    <!-- Módulo 3: Coeficientes Estequiométricos vs Índices Atômicos -->
    <section class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200/90 shadow-sm space-y-5">
        <div class="flex items-center gap-3">
            <span class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-700 flex items-center justify-center font-bold text-lg">03</span>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900">Coeficientes vs Índices: A Regra de Ouro</h2>
        </div>

        <!-- Alerta Importante -->
        <div class="rounded-2xl bg-rose-50 border-2 border-rose-200 p-5 space-y-2">
            <div class="flex items-center gap-2 font-bold text-rose-800 text-base">
                <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <span>ERRO COMUM: NUNCA altere os índices atômicos!</span>
            </div>
            <p class="text-xs sm:text-sm text-rose-700 leading-relaxed">
                Por exemplo, para balancear o oxigênio na síntese da água (<code class="bg-rose-100 px-1 rounded">H₂ + O₂ → H₂O</code>), você <strong>NÃO</strong> pode escrever <code class="bg-rose-100 px-1 rounded line-through">H₂O₂</code>! Água é <code class="bg-rose-100 px-1 rounded">H₂O</code> (essencial para a vida), enquanto <code class="bg-rose-100 px-1 rounded">H₂O₂</code> é água oxigenada (tóxica se ingerida).
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 pt-2">
            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                    <span class="w-6 h-6 rounded bg-emerald-100 text-emerald-800 text-xs flex items-center justify-center font-bold">✓</span>
                    Coeficiente Estequiométrico
                </h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    É o número grande que colocamos <strong>na frente</strong> da fórmula da substância. Ele indica quantas moléculas ou mols daquela substância participam da reação.
                </p>
                <div class="p-3 bg-white rounded-xl border border-slate-200 font-mono text-sm text-center">
                    <strong class="text-emerald-600 text-lg">2</strong> H₂O → Indica <strong>2 moléculas</strong> de água (4 átomos de H e 2 de O).
                </div>
            </div>

            <div class="p-5 rounded-2xl bg-slate-50 border border-slate-200 space-y-2">
                <h3 class="font-bold text-slate-900 text-base flex items-center gap-2">
                    <span class="w-6 h-6 rounded bg-blue-100 text-blue-800 text-xs flex items-center justify-center font-bold">i</span>
                    Índice Atômico (Atomicidade)
                </h3>
                <p class="text-xs text-slate-600 leading-relaxed">
                    É o número subscrito (pequeno) que fica <strong>junto ao símbolo</strong> do elemento. Ele indica a quantidade de átomos daquele elemento presentes em cada molécula da substância.
                </p>
                <div class="p-3 bg-white rounded-xl border border-slate-200 font-mono text-sm text-center">
                    H<strong class="text-blue-600 text-lg">₂</strong>O → O índice <strong>2</strong> pertence exclusivamente ao elemento Hidrogênio.
                </div>
            </div>
        </div>
    </section>

    <!-- Módulo 4: O Método das Tentativas e a Regra MACHO -->
    <section class="bg-white p-6 sm:p-10 rounded-3xl border border-slate-200/90 shadow-sm space-y-6">
        <div class="flex items-center gap-3">
            <span class="w-10 h-10 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-lg">04</span>
            <div>
                <h2 class="text-xl sm:text-2xl font-black text-slate-900">A Regra M.A.C.H.O.</h2>
                <span class="text-xs text-emerald-600 font-bold uppercase tracking-wider">A Ordem de Prioridade Infalível</span>
            </div>
        </div>

        <p class="text-sm sm:text-base text-slate-600 leading-relaxed">
            Ao tentar balancear no "olhômetro" ou por tentativas, muitos estudantes ficam presos em um ciclo onde acertam um elemento e desregulam outro. Para evitar isso, os químicos criaram a regra mnemônica <strong>M.A.C.H.O.</strong>:
        </p>

        <!-- Grade MACHO -->
        <div class="grid grid-cols-1 sm:grid-cols-5 gap-3">
            <div class="p-4 rounded-2xl bg-blue-50 border border-blue-200 text-center space-y-1">
                <div class="text-3xl font-black text-blue-600">M</div>
                <div class="text-xs font-bold text-blue-900 uppercase">Metais</div>
                <p class="text-[11px] text-blue-700">Fe, Al, Ca, Na, K, Mg, etc.</p>
            </div>
            <div class="p-4 rounded-2xl bg-indigo-50 border border-indigo-200 text-center space-y-1">
                <div class="text-3xl font-black text-indigo-600">A</div>
                <div class="text-xs font-bold text-indigo-900 uppercase">Ametais</div>
                <p class="text-[11px] text-indigo-700">S, Cl, N, P, F, Br, etc.</p>
            </div>
            <div class="p-4 rounded-2xl bg-slate-100 border border-slate-300 text-center space-y-1">
                <div class="text-3xl font-black text-slate-700">C</div>
                <div class="text-xs font-bold text-slate-900 uppercase">Carbono</div>
                <p class="text-[11px] text-slate-600">Elemento C central</p>
            </div>
            <div class="p-4 rounded-2xl bg-teal-50 border border-teal-200 text-center space-y-1">
                <div class="text-3xl font-black text-teal-600">H</div>
                <div class="text-xs font-bold text-teal-900 uppercase">Hidrogênio</div>
                <p class="text-[11px] text-teal-700">Elemento H penúltimo</p>
            </div>
            <div class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-center space-y-1">
                <div class="text-3xl font-black text-emerald-600">O</div>
                <div class="text-xs font-bold text-emerald-900 uppercase">Oxigênio</div>
                <p class="text-[11px] text-emerald-700">Elemento O por último</p>
            </div>
        </div>

        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200 text-xs text-slate-600 leading-relaxed space-y-2">
            <div class="font-bold text-slate-800 text-sm">Por que deixar o Oxigênio e o Hidrogênio por último?</div>
            <p>
                Porque o Hidrogênio e, principalmente, o Oxigênio costumam aparecer em quase todas as substâncias da reação (em água, ácidos, bases, óxidos). Quando você acerta os outros átomos primeiro, o Oxigênio se ajusta quase que por consequência natural!
            </p>
        </div>
    </section>

    <!-- Call to Action -->
    <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-emerald-600 p-8 sm:p-10 rounded-3xl text-white text-center space-y-4 shadow-xl">
        <h2 class="text-2xl sm:text-3xl font-extrabold tracking-tight">Pronto para colocar em prática?</h2>
        <p class="text-sm sm:text-base text-blue-100 max-w-xl mx-auto">
            Use nosso Balanceador no modo manual para ver a Regra MACHO sendo aplicada em tempo real em qualquer equação!
        </p>
        <div class="flex flex-wrap items-center justify-center gap-3 pt-2">
            <a href="index.php?modo=manual" class="px-6 py-3 rounded-2xl bg-white text-blue-700 hover:bg-blue-50 font-bold text-sm shadow-md transition-smooth">
                Ir para o Balanceador Manual
            </a>
            <a href="exercicios.php" class="px-6 py-3 rounded-2xl bg-slate-900/40 hover:bg-slate-900/60 text-white font-bold text-sm border border-white/20 transition-smooth">
                Resolver Exercícios
            </a>
        </div>
    </div>

</div>

<?php require_once __DIR__ . '/components/footer.php'; ?>
