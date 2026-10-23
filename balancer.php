<?php
/**
 * BalanceQ - Motor Químico de Balanceamento (balancer.php)
 * Algoritmo exato baseado em Álgebra Linear (Eliminação de Gauss-Jordan) e
 * gerador de passo a passo didático pedagógico (Regra MACHO e Conservação de Lavoisier).
 */

declare(strict_types=1);

/**
 * Máximo Divisor Comum
 */
function math_gcd(int $a, int $b): int {
    $a = abs($a);
    $b = abs($b);
    while ($b > 0) {
        $temp = $b;
        $b = $a % $b;
        $a = $temp;
    }
    return $a;
}

/**
 * Mínimo Múltiplo Comum
 */
function math_lcm(int $a, int $b): int {
    if ($a === 0 || $b === 0) return 0;
    return (int) abs(intdiv($a * $b, math_gcd($a, $b)));
}

/**
 * Classe para Aritmética de Frações Exatas
 */
class Fraction {
    public int $num;
    public int $den;

    public function __construct(int $num, int $den = 1) {
        if ($den === 0) {
            throw new InvalidArgumentException("Divisão por zero em fração matemática.");
        }
        if ($den < 0) {
            $num = -$num;
            $den = -$den;
        }
        $g = math_gcd($num, $den);
        $this->num = intdiv($num, $g);
        $this->den = intdiv($den, $g);
    }

    public function add(Fraction $other): Fraction {
        return new Fraction($this->num * $other->den + $other->num * $this->den, $this->den * $other->den);
    }

    public function sub(Fraction $other): Fraction {
        return new Fraction($this->num * $other->den - $other->num * $this->den, $this->den * $other->den);
    }

    public function mul(Fraction $other): Fraction {
        return new Fraction($this->num * $other->num, $this->den * $other->den);
    }

    public function div(Fraction $other): Fraction {
        if ($other->num === 0) {
            throw new InvalidArgumentException("Divisão por zero.");
        }
        return new Fraction($this->num * $other->den, $this->den * $other->num);
    }

    public function isZero(): bool {
        return $this->num === 0;
    }
}

/**
 * Converte dígitos normais em subscritos unicode para estética química
 */
function toSubscript(string $text): string {
    $map = ['0'=>'₀','1'=>'₁','2'=>'₂','3'=>'₃','4'=>'₄','5'=>'₅','6'=>'₆','7'=>'₇','8'=>'₈','9'=>'₉'];
    return preg_replace_callback('/(?<=[a-zA-Z\)])\d+/', function($m) use ($map) {
        return strtr($m[0], $map);
    }, $text);
}

/**
 * Converte subscritos unicode em dígitos normais para análise
 */
function fromSubscript(string $text): string {
    $map = ['₀'=>'0','₁'=>'1','₂'=>'2','₃'=>'3','₄'=>'4','₅'=>'5','₆'=>'6','₇'=>'7','₈'=>'8','₉'=>'9'];
    return strtr($text, $map);
}

/**
 * Nomes em Português dos principais elementos químicos
 */
function getElementName(string $symbol): string {
    static $elements = [
        'H' => 'Hidrogênio', 'He' => 'Hélio', 'Li' => 'Lítio', 'Be' => 'Berílio', 'B' => 'Boro',
        'C' => 'Carbono', 'N' => 'Nitrogênio', 'O' => 'Oxigênio', 'F' => 'Flúor', 'Ne' => 'Neônio',
        'Na' => 'Sódio', 'Mg' => 'Magnésio', 'Al' => 'Alumínio', 'Si' => 'Silício', 'P' => 'Fósforo',
        'S' => 'Enxofre', 'Cl' => 'Cloro', 'Ar' => 'Argônio', 'K' => 'Potássio', 'Ca' => 'Cálcio',
        'Sc' => 'Escândio', 'Ti' => 'Titânio', 'V' => 'Vanádio', 'Cr' => 'Cromo', 'Mn' => 'Manganês',
        'Fe' => 'Ferro', 'Co' => 'Cobalto', 'Ni' => 'Níquel', 'Cu' => 'Cobre', 'Zn' => 'Zinco',
        'Ga' => 'Gálio', 'Ge' => 'Germânio', 'As' => 'Arsênio', 'Se' => 'Selênio', 'Br' => 'Bromo',
        'Kr' => 'Criptônio', 'Rb' => 'Rubídio', 'Sr' => 'Estrôncio', 'Ag' => 'Prata', 'Cd' => 'Cádmio',
        'Sn' => 'Estanho', 'Sb' => 'Antimônio', 'I' => 'Iodo', 'Ba' => 'Bário', 'Pt' => 'Platina',
        'Au' => 'Ouro', 'Hg' => 'Mercúrio', 'Pb' => 'Chumbo', 'Bi' => 'Bismuto', 'U' => 'Urânio'
    ];
    return $elements[$symbol] ?? $symbol;
}

/**
 * Classificação periódica simplificada para a regra MACHO
 * Retorna categoria: Metal, Ametal, Carbono, Hidrogenio, Oxigenio
 */
function getElementMachoCategory(string $symbol): string {
    if ($symbol === 'C') return 'Carbono';
    if ($symbol === 'H') return 'Hidrogênio';
    if ($symbol === 'O') return 'Oxigênio';

    $metals = [
        'Li','Na','K','Rb','Cs','Fr','Be','Mg','Ca','Sr','Ba','Ra',
        'Al','Ga','In','Sn','Tl','Pb','Bi','Sc','Ti','V','Cr','Mn',
        'Fe','Co','Ni','Cu','Zn','Y','Zr','Nb','Mo','Tc','Ru','Rh',
        'Pd','Ag','Cd','Hf','Ta','W','Re','Os','Ir','Pt','Au','Hg'
    ];
    if (in_array($symbol, $metals, true)) {
        return 'Metal';
    }
    return 'Ametal';
}

/**
 * Analisa a fórmula molecular e extrai a contagem de cada átomo
 */
function parseChemicalFormula(string $formula): array {
    $formula = trim($formula);
    $formula = str_replace(' ', '', $formula);
    $formula = fromSubscript($formula);
    $formula = str_replace(['[', '{'], '(', $formula);
    $formula = str_replace([']', '}'], ')', $formula);

    if (empty($formula)) {
        throw new InvalidArgumentException("Fórmula molecular vazia identificada.");
    }

    $stack = [[]];
    $i = 0;
    $len = strlen($formula);

    while ($i < $len) {
        $ch = $formula[$i];

        if ($ch === '(') {
            $stack[] = [];
            $i++;
        } elseif ($ch === ')') {
            $i++;
            $numStr = '';
            while ($i < $len && ctype_digit($formula[$i])) {
                $numStr .= $formula[$i];
                $i++;
            }
            $mult = $numStr === '' ? 1 : intval($numStr);
            if ($mult <= 0) {
                throw new InvalidArgumentException("Índice de grupo molecular inválido: '$mult'");
            }
            if (count($stack) <= 1) {
                throw new InvalidArgumentException("Parêntese de fechamento ')' sem abertura correspondente na fórmula '$formula'.");
            }
            $group = array_pop($stack);
            $topIndex = count($stack) - 1;
            foreach ($group as $elem => $cnt) {
                $stack[$topIndex][$elem] = ($stack[$topIndex][$elem] ?? 0) + ($cnt * $mult);
            }
        } elseif (ctype_upper($ch)) {
            $elem = $ch;
            $i++;
            if ($i < $len && ctype_lower($formula[$i])) {
                $elem .= $formula[$i];
                $i++;
            }
            $numStr = '';
            while ($i < $len && ctype_digit($formula[$i])) {
                $numStr .= $formula[$i];
                $i++;
            }
            $cnt = $numStr === '' ? 1 : intval($numStr);
            $topIndex = count($stack) - 1;
            $stack[$topIndex][$elem] = ($stack[$topIndex][$elem] ?? 0) + $cnt;
        } else {
            throw new InvalidArgumentException("Caractere inválido ou inesperado na fórmula '{$formula}': '{$ch}'. Lembre-se de utilizar a primeira letra maiúscula (ex: 'Na', 'Cl', 'Fe').");
        }
    }

    if (count($stack) !== 1) {
        throw new InvalidArgumentException("Parênteses não fechados na fórmula '{$formula}'.");
    }

    return $stack[0];
}

/**
 * Função principal de balanceamento estequiométrico
 */
function balanceChemicalEquation(string $equation, string $modo = 'automatico'): array {
    $rawInput = trim($equation);
    if (empty($rawInput)) {
        throw new InvalidArgumentException("Por favor, digite uma equação química para balancear.");
    }

    // Normaliza os delimitadores de reação
    $cleanEq = str_replace(['-->', '==>', '<=>', '⇄', '⇌', '->', '=>', '='], '→', $rawInput);
    $parts = explode('→', $cleanEq);

    if (count($parts) < 2) {
        throw new InvalidArgumentException("A equação deve conter reagentes e produtos separados por seta (ex: 'H2 + O2 -> H2O').");
    }
    if (count($parts) > 2) {
        throw new InvalidArgumentException("A equação deve conter apenas uma única seta de reação separando os dois lados.");
    }

    $rawReactants = array_values(array_filter(array_map('trim', explode('+', $parts[0]))));
    $rawProducts = array_values(array_filter(array_map('trim', explode('+', $parts[1]))));

    if (empty($rawReactants)) {
        throw new InvalidArgumentException("Nenhum reagente válido foi encontrado antes da seta.");
    }
    if (empty($rawProducts)) {
        throw new InvalidArgumentException("Nenhum produto válido foi encontrado após a seta.");
    }

    // Limpa coeficientes anteriores se houver (ex: se o usuário já digitou '2 H2')
    $reactants = [];
    foreach ($rawReactants as $r) {
        $c = preg_replace('/^\d+\s*/', '', fromSubscript($r));
        if (!empty($c)) $reactants[] = $c;
    }
    $products = [];
    foreach ($rawProducts as $p) {
        $c = preg_replace('/^\d+\s*/', '', fromSubscript($p));
        if (!empty($c)) $products[] = $c;
    }

    $species = array_merge($reactants, $products);
    $nReactants = count($reactants);
    $nProducts = count($products);
    $nTotal = count($species);

    // Contagem atômica de cada espécie
    $speciesCounts = [];
    $allElements = [];
    foreach ($species as $idx => $spec) {
        $counts = parseChemicalFormula($spec);
        $speciesCounts[$idx] = $counts;
        foreach (array_keys($counts) as $el) {
            $allElements[$el] = true;
        }
    }
    $elements = array_keys($allElements);

    // Validação estrita da conservação de elementos (Lavoisier)
    $reactantsElements = [];
    for ($i = 0; $i < $nReactants; $i++) {
        foreach (array_keys($speciesCounts[$i]) as $el) {
            $reactantsElements[$el] = true;
        }
    }
    $productsElements = [];
    for ($i = $nReactants; $i < $nTotal; $i++) {
        foreach (array_keys($speciesCounts[$i]) as $el) {
            $productsElements[$el] = true;
        }
    }

    foreach ($elements as $el) {
        $elName = getElementName($el);
        if (!isset($reactantsElements[$el])) {
            throw new InvalidArgumentException("O elemento {$elName} ({$el}) aparece nos produtos, mas não existe nos reagentes! Pelo princípio de Lavoisier ('Nada se cria, nada se perde'), novos elementos não surgem espontaneamente.");
        }
        if (!isset($productsElements[$el])) {
            throw new InvalidArgumentException("O elemento {$elName} ({$el}) aparece nos reagentes, mas não existe nos produtos! Pelo princípio de Lavoisier, matéria não pode ser destruída.");
        }
    }

    // Monta o sistema de equações lineares estequiométricas
    $matrix = [];
    foreach ($elements as $el) {
        $row = [];
        for ($j = 0; $j < $nTotal; $j++) {
            $count = $speciesCounts[$j][$el] ?? 0;
            if ($j >= $nReactants) {
                $count = -$count;
            }
            $row[] = new Fraction($count, 1);
        }
        $matrix[] = $row;
    }

    // Eliminação de Gauss-Jordan
    $numRows = count($matrix);
    $numCols = $nTotal;
    $lead = 0;

    for ($r = 0; $r < $numRows; $r++) {
        if ($lead >= $numCols) break;
        $i = $r;
        while ($matrix[$i][$lead]->isZero()) {
            $i++;
            if ($i === $numRows) {
                $i = $r;
                $lead++;
                if ($lead === $numCols) break 2;
            }
        }
        $temp = $matrix[$i];
        $matrix[$i] = $matrix[$r];
        $matrix[$r] = $temp;

        $pivot = $matrix[$r][$lead];
        for ($j = 0; $j < $numCols; $j++) {
            $matrix[$r][$j] = $matrix[$r][$j]->div($pivot);
        }

        for ($i = 0; $i < $numRows; $i++) {
            if ($i !== $r) {
                $factor = $matrix[$i][$lead];
                if (!$factor->isZero()) {
                    for ($j = 0; $j < $numCols; $j++) {
                        $matrix[$i][$j] = $matrix[$i][$j]->sub($factor->mul($matrix[$r][$j]));
                    }
                }
            }
        }
        $lead++;
    }

    // Identifica colunas pivô e livres
    $pivotCols = [];
    for ($r = 0; $r < $numRows; $r++) {
        for ($c = 0; $c < $numCols; $c++) {
            if (!$matrix[$r][$c]->isZero()) {
                $pivotCols[$r] = $c;
                break;
            }
        }
    }

    $freeCols = array_values(array_diff(range(0, $numCols - 1), array_values($pivotCols)));
    if (empty($freeCols)) {
        throw new InvalidArgumentException("A equação química fornecida não possui solução estequiométrica com conservação de massas.");
    }

    // Calcula solução inicial no espaço nulo
    $lastFree = end($freeCols);
    $sol = array_fill(0, $numCols, new Fraction(0, 1));
    $sol[$lastFree] = new Fraction(1, 1);

    for ($r = count($pivotCols) - 1; $r >= 0; $r--) {
        $pCol = $pivotCols[$r];
        $sum = new Fraction(0, 1);
        for ($c = $pCol + 1; $c < $numCols; $c++) {
            $sum = $sum->add($matrix[$r][$c]->mul($sol[$c]));
        }
        $sol[$pCol] = (new Fraction(0, 1))->sub($sum);
    }

    // Inverte se todos forem negativos
    $allNeg = true;
    foreach ($sol as $f) {
        if ($f->num > 0) { $allNeg = false; break; }
    }
    if ($allNeg) {
        foreach ($sol as $idx => $f) {
            $sol[$idx] = new Fraction(-$f->num, $f->den);
        }
    }

    // MMC dos denominadores para converter em inteiros
    $denLcm = 1;
    foreach ($sol as $f) {
        $denLcm = math_lcm($denLcm, $f->den);
    }

    $intCoeffs = [];
    foreach ($sol as $f) {
        $intCoeffs[] = intval($f->num * ($denLcm / $f->den));
    }

    // MDC de todos os coeficientes para simplificar aos menores inteiros
    $overallGcd = $intCoeffs[0];
    for ($i = 1; $i < count($intCoeffs); $i++) {
        $overallGcd = math_gcd($overallGcd, $intCoeffs[$i]);
    }

    $finalCoeffs = [];
    foreach ($intCoeffs as $c) {
        $val = intdiv($c, $overallGcd);
        if ($val <= 0) {
            throw new InvalidArgumentException("Não foi possível balancear esta equação química. Verifique as fórmulas informadas.");
        }
        $finalCoeffs[] = $val;
    }

    $reactantCoeffs = array_slice($finalCoeffs, 0, $nReactants);
    $productCoeffs = array_slice($finalCoeffs, $nReactants);

    // Contagem de átomos antes (coeficientes = 1) e depois (coeficientes calculados)
    $beforeAtoms = [];
    $afterAtoms = [];

    foreach ($elements as $el) {
        $rBefore = 0;
        for ($i = 0; $i < $nReactants; $i++) {
            $rBefore += ($speciesCounts[$i][$el] ?? 0);
        }
        $pBefore = 0;
        for ($i = $nReactants; $i < $nTotal; $i++) {
            $pBefore += ($speciesCounts[$i][$el] ?? 0);
        }

        $rAfter = 0;
        for ($i = 0; $i < $nReactants; $i++) {
            $rAfter += ($speciesCounts[$i][$el] ?? 0) * $reactantCoeffs[$i];
        }
        $pAfter = 0;
        for ($i = 0; $i < $nProducts; $i++) {
            $pAfter += ($speciesCounts[$nReactants + $i][$el] ?? 0) * $productCoeffs[$i];
        }

        $beforeAtoms[$el] = [
            'name' => getElementName($el),
            'reactants' => $rBefore,
            'products' => $pBefore,
            'balanced' => ($rBefore === $pBefore)
        ];

        $afterAtoms[$el] = [
            'name' => getElementName($el),
            'reactants' => $rAfter,
            'products' => $pAfter,
            'balanced' => ($rAfter === $pAfter)
        ];
    }

    // Formatações visuais em HTML e texto
    $beforeReactantsStr = [];
    foreach ($reactants as $r) {
        $beforeReactantsStr[] = toSubscript($r);
    }
    $beforeProductsStr = [];
    foreach ($products as $p) {
        $beforeProductsStr[] = toSubscript($p);
    }
    $beforeEquationStr = implode(' + ', $beforeReactantsStr) . ' → ' . implode(' + ', $beforeProductsStr);

    $balancedReactantsParts = [];
    $balancedReactantsHtml = [];
    foreach ($reactants as $idx => $r) {
        $coeff = $reactantCoeffs[$idx];
        $coeffText = $coeff > 1 ? "{$coeff} " : "";
        $balancedReactantsParts[] = $coeffText . toSubscript($r);
        
        $coeffBadge = $coeff > 1 
            ? "<span class='font-black text-emerald-600 bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-400 px-1.5 py-0.5 rounded-md'>{$coeff}</span> " 
            : "<span class='text-slate-400 dark:text-slate-500 font-semibold'>1</span> ";
        $balancedReactantsHtml[] = $coeffBadge . "<span class='font-medium text-slate-800 dark:text-slate-200'>" . toSubscript($r) . "</span>";
    }

    $balancedProductsParts = [];
    $balancedProductsHtml = [];
    foreach ($products as $idx => $p) {
        $coeff = $productCoeffs[$idx];
        $coeffText = $coeff > 1 ? "{$coeff} " : "";
        $balancedProductsParts[] = $coeffText . toSubscript($p);

        $coeffBadge = $coeff > 1 
            ? "<span class='font-black text-emerald-600 bg-emerald-100 dark:bg-emerald-950/60 dark:text-emerald-400 px-1.5 py-0.5 rounded-md'>{$coeff}</span> " 
            : "<span class='text-slate-400 dark:text-slate-500 font-semibold'>1</span> ";
        $balancedProductsHtml[] = $coeffBadge . "<span class='font-medium text-slate-800 dark:text-slate-200'>" . toSubscript($p) . "</span>";
    }

    $balancedEquationStr = implode(' + ', $balancedReactantsParts) . ' → ' . implode(' + ', $balancedProductsParts);
    $balancedEquationHtml = implode(' + ', $balancedReactantsHtml) . " <span class='text-blue-500 font-bold mx-1'>→</span> " . implode(' + ', $balancedProductsHtml);

    // Geração do Passo a Passo Pedagógico (Regra MACHO e Lavoisier)
    $steps = generateDidacticSteps(
        $reactants, $products, $reactantCoeffs, $productCoeffs,
        $elements, $beforeAtoms, $afterAtoms, $speciesCounts, $nReactants
    );

    return [
        'success' => true,
        'original' => $rawInput,
        'before_str' => $beforeEquationStr,
        'balanced_str' => $balancedEquationStr,
        'balanced_html' => $balancedEquationHtml,
        'reactants' => array_map('toSubscript', $reactants),
        'products' => array_map('toSubscript', $products),
        'reactant_coeffs' => $reactantCoeffs,
        'product_coeffs' => $productCoeffs,
        'elements' => $elements,
        'before_atoms' => $beforeAtoms,
        'after_atoms' => $afterAtoms,
        'is_balanced' => true,
        'modo' => $modo,
        'steps' => $steps
    ];
}

/**
 * Gera as explicações estruturadas para o modo Manual / Passo a Passo
 */
function generateDidacticSteps(
    array $reactants, array $products, array $rCoeffs, array $pCoeffs,
    array $elements, array $beforeAtoms, array $afterAtoms, array $speciesCounts, int $nReactants
): array {
    $steps = [];

    // Etapa 1: Identificação de reagentes e produtos
    $steps[] = [
        'num' => 1,
        'title' => 'Identificação de Reagentes e Produtos',
        'desc' => 'Separamos a equação química em duas partes fundamentais: à esquerda da seta estão as substâncias que reagem (reagentes) e à direita estão as substâncias produzidas (produtos).',
        'items' => [
            'Reagentes: ' . implode(', ', array_map('toSubscript', $reactants)),
            'Produtos: ' . implode(', ', array_map('toSubscript', $products))
        ]
    ];

    // Etapa 2: Diagnóstico e contagem inicial de átomos
    $unbalancedElements = [];
    foreach ($beforeAtoms as $el => $data) {
        if (!$data['balanced']) {
            $unbalancedElements[] = "{$data['name']} ({$el}): {$data['reactants']} nos reagentes ≠ {$data['products']} nos produtos";
        }
    }

    $steps[] = [
        'num' => 2,
        'title' => 'Inventário Inicial de Átomos (Antes do Ajuste)',
        'desc' => empty($unbalancedElements) 
            ? 'A equação original já estava naturalmente equilibrada!'
            : 'Contamos a quantidade de cada tipo de átomo nos dois lados. Observamos que os seguintes elementos precisam de ajuste:',
        'items' => empty($unbalancedElements) ? ['Nenhum ajuste necessário.'] : $unbalancedElements,
        'is_balanced_before' => empty($unbalancedElements)
    ];

    // Etapa 3: Aplicação da Regra MACHO
    // Ordena elementos: Metais -> Ametais -> Carbono -> Hidrogênio -> Oxigênio
    $orderMap = ['Metal' => 1, 'Ametal' => 2, 'Carbono' => 3, 'Hidrogênio' => 4, 'Oxigênio' => 5];
    $sortedElements = $elements;
    usort($sortedElements, function($a, $b) use ($orderMap) {
        $catA = getElementMachoCategory($a);
        $catB = getElementMachoCategory($b);
        $diff = ($orderMap[$catA] ?? 99) - ($orderMap[$catB] ?? 99);
        if ($diff !== 0) return $diff;
        return strcmp($a, $b);
    });

    $machoExplanations = [];
    foreach ($sortedElements as $el) {
        $cat = getElementMachoCategory($el);
        $name = getElementName($el);
        $finalCount = $afterAtoms[$el]['reactants'];
        $machoExplanations[] = "<strong>[{$cat}] {$name} ({$el})</strong>: Ajustado para conter exatamente {$finalCount} átomos de cada lado.";
    }

    $steps[] = [
        'num' => 3,
        'title' => 'Ajuste Estequiométrico pela Regra M.A.C.H.O.',
        'desc' => 'Na química, a sequência mais eficiente para balanceamento é seguir a prioridade: <strong>M</strong>etais → <strong>A</strong>metais → <strong>C</strong>arbono → <strong>H</strong>idrogênio → <strong>O</strong>xigênio. Ajustamos os coeficientes sem nunca alterar os índices das fórmulas químicas:',
        'items' => $machoExplanations
    ];

    // Etapa 4: Validação pela Lei de Lavoisier
    $lavoisierItems = [];
    foreach ($afterAtoms as $el => $data) {
        $lavoisierItems[] = "{$data['name']} ({$el}): {$data['reactants']} átomos nos reagentes = {$data['products']} átomos nos produtos ✓";
    }

    $steps[] = [
        'num' => 4,
        'title' => 'Comprovação da Lei de Conservação da Massa (Lavoisier)',
        'desc' => '<em>"Na natureza nada se cria, nada se perde, tudo se transforma."</em> O balanço final comprova que o número e o tipo de átomos é rigorosamente idêntico em ambos os lados:',
        'items' => $lavoisierItems
    ];

    return $steps;
}
