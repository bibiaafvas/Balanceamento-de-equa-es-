<?php
/**
 * BalanceQ - Área Interativa de Exercícios (exercicios.php)
 * Níveis: Fácil, Médio e Difícil com verificação instantânea e educativa.
 */

declare(strict_types=1);

require_once __DIR__ . '/auth.php';
require_once __DIR__ . '/balancer.php';

$pageTitle = 'Exercícios de Balanceamento - BalanceQ';

// Lista de exercícios pedagógicos estruturados
$exercicios = [
    'facil' => [
        [
            'id' => 1,
            'title' => 'Síntese da Água',
            'desc' => 'Reação entre hidrogênio e oxigênio molecular.',
            'equation' => 'H2 + O2 -> H2O',
            'reactants' => ['H₂', 'O₂'],
            'products' => ['H₂O'],
            'r_expected' => [2, 1],
            'p_expected' => [2]
        ],
        [
            'id' => 2,
            'title' => 'Síntese da Amônia (Processo Haber)',
            'desc' => 'Produção de amônia a partir do nitrogênio do ar.',
            'equation' => 'N2 + H2 -> NH3',
            'reactants' => ['N₂', 'H₂'],
            'products' => ['NH₃'],
            'r_expected' => [1, 3],
            'p_expected' => [2]
        ],
        [
            'id' => 3,
            'title' => 'Combustão do Magnésio',
            'desc' => 'Produz um clarão branco intenso característico.',
            'equation' => 'Mg + O2 -> MgO',
            'reactants' => ['Mg', 'O₂'],
            'products' => ['MgO'],
            'r_expected' => [2, 1],
            'p_expected' => [2]
        ],
        [
            'id' => 4,
            'title' => 'Formação do Sal de Cozinha',
            'desc' => 'Reação vigorosa entre sódio metálico e gás cloro.',
            'equation' => 'Na + Cl2 -> NaCl',
            'reactants' => ['Na', 'Cl₂'],
            'products' => ['NaCl'],
            'r_expected' => [2, 1],
            'p_expected' => [2]
        ]
    ],
    'medio' => [
        [
            'id' => 5,
            'title' => 'Combustão Completa do Metano',
            'desc' => 'Queima do principal componente do gás natural.',
            'equation' => 'CH4 + O2 -> CO2 + H2O',
            'reactants' => ['CH₄', 'O₂'],
            'products' => ['CO₂', 'H₂O'],
            'r_expected' => [1, 2],
            'p_expected' => [1, 2]
        ],
        [
            'id' => 6,
            'title' => 'Oxidação do Ferro (Ferrugem)',
            'desc' => 'Formação de óxido de ferro(III) exposto ao ar.',
            'equation' => 'Fe + O2 -> Fe2O3',
            'reactants' => ['Fe', 'O₂'],
            'products' => ['Fe₂O₃'],
            'r_expected' => [4, 3],
            'p_expected' => [2]
        ],
        [
            'id' => 7,
            'title' => 'Reação de Alumínio com Ácido Clorídrico',
            'desc' => 'Liberação de gás hidrogênio em meio ácido.',
            'equation' => 'Al + HCl -> AlCl3 + H2',
            'reactants' => ['Al', 'HCl'],
            'products' => ['AlCl₃', 'H₂'],
            'r_expected' => [2, 6],
            'p_expected' => [2, 3]
        ],
        [
            'id' => 8,
            'title' => 'Decomposição do Clorato de Potássio',
            'desc' => 'Método clássico laboratorial de obtenção de oxigênio.',
            'equation' => 'KClO3 -> KCl + O2',
            'reactants' => ['KClO₃'],
            'products' => ['KCl', 'O₂'],
            'r_expected' => [2],
            'p_expected' => [2, 3]
        ]
    ],
    'dificil' => [
        [
            'id' => 9,
            'title' => 'Combustão do Gás Propano',
            'desc' => 'Queima do gás presente no botijão de cozinha (GLP).',
            'equation' => 'C3H8 + O2 -> CO2 + H2O',
            'reactants' => ['C₃H₈', 'O₂'],
            'products' => ['CO₂', 'H₂O'],
            'r_expected' => [1, 5],
            'p_expected' => [3, 4]
        ],
        [
            'id' => 10,
            'title' => 'Redução Siderúrgica no Alto-Forno',
            'desc' => 'Produção de ferro gusa a partir de minério e monóxido de carbono.',
            'equation' => 'Fe2O3 + CO -> Fe + CO2',
            'reactants' => ['Fe₂O₃', 'CO'],
            'products' => ['Fe', 'CO₂'],
            'r_expected' => [1, 3],
            'p_expected' => [2, 3]
        ],
        [
            'id' => 11,
            'title' => 'Precipitação com Sulfato de Alumínio',
            'desc' => 'Tratamento de água com cal hidratada.',
            'equation' => 'Al2(SO4)3 + Ca(OH)2 -> Al(OH)3 + CaSO4',
            'reactants' => ['Al₂(SO₄)₃', 'Ca(OH)₂'],
            'products' => ['Al(OH)₃', 'CaSO₄'],
            'r_expected' => [1, 3],
            'p_expected' => [2, 3]
        ],
        [
            'id' => 12,
            'title' => 'Oxirredução com Permanganato de Potássio',
            'desc' => 'Reação redox clássica em meio ácido clorídrico concentrado.',
            'equation' => 'KMnO4 + HCl -> KCl + MnCl2 + Cl2 + H2O',
            'reactants' => ['KMnO₄', 'HCl'],
            'products' => ['KCl', 'MnCl₂', 'Cl₂', 'H₂O'],
            'r_expected' => [2, 16],
            'p_expected' => [2, 2, 5, 8]
        ]
    ]
];

require_once __DIR__ . '/components/header.php';
?>

<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    
    <!-- Cabeçalho -->
    <div class="text-center max-w-3xl mx-auto mb-10 space-y-3">
        <div class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-100 text-emerald-800 text-xs font-bold">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span>Laboratório de Prática</span>
        </div>
        <h1 class="text-3xl sm:text-5xl font-black text-slate-900 tracking-tight">Treinamento de Balanceamento</h1>
        <p class="text-sm sm:text-base text-slate-600">
            Digite os coeficientes estequiométricos nos campos em branco e clique em <strong>Verificar</strong> para conferir se o número de átomos está balanceado.
        </p>
    </div>

    <!-- Seletor de Dificuldade -->
    <div class="flex items-center justify-center gap-2 mb-8">
        <button 
            type="button" 
            onclick="filterDifficulty('facil')" 
            id="btn-diff-facil"
            class="px-5 py-2.5 rounded-2xl font-bold text-xs sm:text-sm bg-emerald-600 text-white shadow-md shadow-emerald-600/20 transition-smooth"
        >
            Fácil (Iniciante)
        </button>
        <button 
            type="button" 
            onclick="filterDifficulty('medio')" 
            id="btn-diff-medio"
            class="px-5 py-2.5 rounded-2xl font-bold text-xs sm:text-sm bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 transition-smooth"
        >
            Médio (Intermediário)
        </button>
        <button 
            type="button" 
            onclick="filterDifficulty('dificil')" 
            id="btn-diff-dificil"
            class="px-5 py-2.5 rounded-2xl font-bold text-xs sm:text-sm bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 transition-smooth"
        >
            Difícil (Avançado / Redox)
        </button>
    </div>

    <!-- Lista de Exercícios por Nível -->
    <div class="space-y-6">
        <?php foreach ($exercicios as $level => $items): ?>
            <div id="group-<?= $level ?>" class="difficulty-group space-y-6 <?= $level !== 'facil' ? 'hidden' : '' ?>">
                
                <?php foreach ($items as $ex): ?>
                    <div class="bg-white p-6 sm:p-8 rounded-3xl border border-slate-200/90 shadow-sm hover:shadow-md transition-smooth space-y-5" id="card-ex-<?= $ex['id'] ?>">
                        
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-100 pb-3">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Exercício #<?= $ex['id'] ?></span>
                                <h3 class="text-lg font-bold text-slate-900"><?= htmlspecialchars($ex['title']) ?></h3>
                                <p class="text-xs text-slate-500"><?= htmlspecialchars($ex['desc']) ?></p>
                            </div>
                            <span class="px-2.5 py-1 rounded-lg text-xs font-bold uppercase tracking-wider self-start sm:self-center <?= $level === 'facil' ? 'bg-emerald-100 text-emerald-800' : ($level === 'medio' ? 'bg-amber-100 text-amber-800' : 'bg-rose-100 text-rose-800') ?>">
                                <?= ucfirst($level) ?>
                            </span>
                        </div>

                        <!-- Área Interativa da Equação -->
                        <div class="bg-slate-50 p-4 sm:p-6 rounded-2xl border border-slate-200/70 overflow-x-auto">
                            <div class="flex items-center gap-2 font-mono-chem text-lg sm:text-xl font-bold text-slate-800 min-w-max">
                                
                                <!-- Reagentes com inputs -->
                                <?php foreach ($ex['reactants'] as $rIdx => $rMol): ?>
                                    <?php if ($rIdx > 0): ?><span class="text-slate-400 font-bold mx-1">+</span><?php endif; ?>
                                    <div class="inline-flex items-center gap-1.5">
                                        <input 
                                            type="number" 
                                            min="1" 
                                            max="99" 
                                            placeholder="1"
                                            id="ex-<?= $ex['id'] ?>-r-<?= $rIdx ?>"
                                            class="w-12 h-11 text-center font-bold text-base bg-white border-2 border-slate-300 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 text-slate-900"
                                        >
                                        <span class="text-slate-900"><?= $rMol ?></span>
                                    </div>
                                <?php endforeach; ?>

                                <!-- Seta da Reação -->
                                <span class="text-blue-600 font-bold mx-3 text-2xl">→</span>

                                <!-- Produtos com inputs -->
                                <?php foreach ($ex['products'] as $pIdx => $pMol): ?>
                                    <?php if ($pIdx > 0): ?><span class="text-slate-400 font-bold mx-1">+</span><?php endif; ?>
                                    <div class="inline-flex items-center gap-1.5">
                                        <input 
                                            type="number" 
                                            min="1" 
                                            max="99" 
                                            placeholder="1"
                                            id="ex-<?= $ex['id'] ?>-p-<?= $pIdx ?>"
                                            class="w-12 h-11 text-center font-bold text-base bg-white border-2 border-slate-300 rounded-xl focus:outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100 text-slate-900"
                                        >
                                        <span class="text-slate-900"><?= $pMol ?></span>
                                    </div>
                                <?php endforeach; ?>

                            </div>
                        </div>

                        <!-- Feedback de Resposta -->
                        <div id="feedback-ex-<?= $ex['id'] ?>" class="hidden p-4 rounded-2xl text-sm font-medium"></div>

                        <!-- Ações do Exercício -->
                        <div class="flex flex-wrap items-center justify-between gap-3 pt-1">
                            <button 
                                type="button" 
                                onclick="verifyExercise(<?= $ex['id'] ?>, '<?= $ex['equation'] ?>', <?= json_encode($ex['r_expected']) ?>, <?= json_encode($ex['p_expected']) ?>)"
                                class="px-5 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-emerald-600 hover:from-blue-700 hover:to-emerald-700 text-white font-bold text-xs sm:text-sm shadow-md shadow-blue-500/20 transition-smooth flex items-center gap-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>Verificar Resposta</span>
                            </button>

                            <a 
                                href="index.php?eq=<?= urlencode($ex['equation']) ?>&modo=manual"
                                class="text-xs font-bold text-blue-600 hover:text-blue-800 hover:underline flex items-center gap-1"
                            >
                                <span>Ver resolução com passo a passo</span>
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>

                    </div>
                <?php endforeach; ?>

            </div>
        <?php endforeach; ?>
    </div>

</div>

<script>
    function filterDifficulty(level) {
        document.querySelectorAll('.difficulty-group').forEach(el => el.classList.add('hidden'));
        document.getElementById(`group-${level}`)?.classList.remove('hidden');

        ['facil', 'medio', 'dificil'].forEach(lvl => {
            const btn = document.getElementById(`btn-diff-${lvl}`);
            if (lvl === level) {
                btn.className = 'px-5 py-2.5 rounded-2xl font-bold text-xs sm:text-sm bg-emerald-600 text-white shadow-md shadow-emerald-600/20 transition-smooth';
            } else {
                btn.className = 'px-5 py-2.5 rounded-2xl font-bold text-xs sm:text-sm bg-white text-slate-700 hover:bg-slate-100 border border-slate-200 transition-smooth';
            }
        });
    }

    function verifyExercise(id, equation, expectedR, expectedP) {
        const userR = [];
        for (let i = 0; i < expectedR.length; i++) {
            const val = document.getElementById(`ex-${id}-r-${i}`)?.value.trim();
            userR.push(val === '' ? 1 : parseInt(val, 10));
        }

        const userP = [];
        for (let i = 0; i < expectedP.length; i++) {
            const val = document.getElementById(`ex-${id}-p-${i}`)?.value.trim();
            userP.push(val === '' ? 1 : parseInt(val, 10));
        }

        const isCorrect = (JSON.stringify(userR) === JSON.stringify(expectedR)) && 
                          (JSON.stringify(userP) === JSON.stringify(expectedP));

        const feedback = document.getElementById(`feedback-ex-${id}`);
        if (!feedback) return;

        feedback.classList.remove('hidden', 'bg-emerald-50', 'text-emerald-800', 'border-emerald-200', 'bg-rose-50', 'text-rose-800', 'border-rose-200');

        if (isCorrect) {
            feedback.classList.add('bg-emerald-50', 'text-emerald-800', 'border', 'border-emerald-200');
            feedback.innerHTML = `
                <div class="flex items-center gap-2 font-bold text-base mb-1">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Excelente! Equação balanceada corretamente!</span>
                </div>
                <p>Todos os átomos nos reagentes são rigorosamente iguais aos átomos nos produtos, obedecendo ao princípio da conservação das massas de Lavoisier.</p>
            `;
            showToast('Parabéns! Resposta correta!', 'success');
        } else {
            feedback.classList.add('bg-rose-50', 'text-rose-800', 'border', 'border-rose-200');
            feedback.innerHTML = `
                <div class="flex items-center gap-2 font-bold text-base mb-1">
                    <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span>Ainda não está correto. Tente novamente!</span>
                </div>
                <p>Dica: Comece aplicando a Regra MACHO (Metais, Ametais, Carbono, Hidrogênio, Oxigênio) e conte a quantidade de cada átomo dos dois lados.</p>
            `;
            showToast('Resposta incorreta. Ajuste os coeficientes e tente de novo!', 'error');
        }
    }
</script>

<?php require_once __DIR__ . '/components/footer.php'; ?>
