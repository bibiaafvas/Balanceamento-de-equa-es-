<?php
/**
 * BalanceQ - Cabeçalho e Navegação (header.php)
 */
require_once __DIR__ . '/../auth.php';
$currentUser = getCurrentUser();
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="pt-BR" class="h-full bg-slate-50">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'BalanceQ - Balanceamento de Equações Químicas' ?></title>
    <meta name="description" content="Balanceador de equações químicas interativo, educativo e rápido. Aprenda passo a passo com a Lei de Lavoisier e a Regra MACHO.">
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        chem: {
                            blue: '#2563eb',
                            green: '#10b981',
                            dark: '#0f172a',
                            light: '#f8fafc'
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=JetBrains+Mono:wght@500;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-mono-chem { font-family: 'JetBrains Mono', monospace; }
    </style>
</head>
<body class="flex flex-col min-h-full text-slate-800 antialiased selection:bg-emerald-500 selection:text-white">

    <!-- Top Navigation -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur border-b border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                
                <!-- Logo & Brand -->
                <a href="index.php" class="flex items-center gap-3 group">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gradient-to-tr from-blue-600 via-indigo-600 to-emerald-500 flex items-center justify-center text-white shadow-md shadow-blue-500/20 group-hover:scale-105 transition-smooth">
                        <!-- Ícone de Bequer / Reação Química SVG -->
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/>
                        </svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5">
                            <span class="text-xl sm:text-2xl font-extrabold tracking-tight bg-gradient-to-r from-blue-700 via-indigo-700 to-emerald-600 bg-clip-text text-transparent">BalanceQ</span>
                            <span class="text-[10px] font-bold uppercase tracking-wider px-1.5 py-0.5 rounded bg-emerald-100 text-emerald-800">Química</span>
                        </div>
                        <p class="text-[11px] text-slate-500 hidden sm:block font-medium">Equilíbrio & Estequiometria</p>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-1 lg:gap-2">
                    <a href="index.php" class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-smooth <?= $currentPage === 'index.php' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' ?>">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                            Balanceador
                        </span>
                    </a>
                    <a href="historico.php" class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-smooth <?= $currentPage === 'historico.php' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' ?>">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Histórico & Salvos
                        </span>
                    </a>
                    <a href="exercicios.php" class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-smooth <?= $currentPage === 'exercicios.php' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' ?>">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Exercícios
                        </span>
                    </a>
                    <a href="estudos.php" class="px-3.5 py-2 rounded-lg text-sm font-semibold transition-smooth <?= $currentPage === 'estudos.php' ? 'bg-blue-50 text-blue-700 font-bold' : 'text-slate-600 hover:text-slate-900 hover:bg-slate-100' ?>">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Estudos & Lavoisier
                        </span>
                    </a>
                </nav>

                <!-- User Area (Gmail Core Requirement) -->
                <div class="flex items-center gap-3">
                    <?php if ($currentUser): ?>
                        <div class="flex items-center gap-3 pl-3 sm:border-l border-slate-200">
                            <div class="hidden sm:block text-right">
                                <div class="text-sm font-bold text-slate-800 leading-tight"><?= htmlspecialchars($currentUser['nome']) ?></div>
                                <div class="text-xs text-slate-500 font-medium flex items-center gap-1 justify-end">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 inline-block"></span>
                                    <?= htmlspecialchars($currentUser['email']) ?>
                                </div>
                            </div>
                            <img src="<?= htmlspecialchars($currentUser['foto']) ?>" alt="Avatar" class="w-9 h-9 sm:w-10 sm:h-10 rounded-full ring-2 ring-emerald-500/30 object-cover bg-slate-100">
                            <a href="login.php?logout=1" class="text-xs font-semibold text-rose-600 hover:text-rose-700 bg-rose-50 hover:bg-rose-100 px-2.5 py-1.5 rounded-lg transition-smooth flex items-center gap-1" title="Sair da conta">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                <span class="hidden sm:inline">Sair</span>
                            </a>
                        </div>
                    <?php else: ?>
                        <a href="login.php" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 shadow-sm shadow-blue-500/25 transition-smooth">
                            <svg class="w-4 h-4" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/>
                                <path fill="currentColor" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/>
                                <path fill="currentColor" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z" fill="#FBBC05"/>
                                <path fill="currentColor" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z" fill="#EA4335"/>
                            </svg>
                            <span>Entrar com Gmail</span>
                        </a>
                    <?php endif; ?>

                    <!-- Mobile Hamburger Button -->
                    <button id="mobileMenuBtn" type="button" class="md:hidden p-2 rounded-lg text-slate-600 hover:text-slate-900 hover:bg-slate-100 transition-smooth" aria-label="Abrir Menu">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Navigation Menu -->
        <div id="mobileMenu" class="hidden md:hidden border-t border-slate-200 bg-white px-4 pt-2 pb-4 space-y-1">
            <a href="index.php" class="block px-3 py-2 rounded-lg text-base font-semibold <?= $currentPage === 'index.php' ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-100' ?>">Balanceador</a>
            <a href="historico.php" class="block px-3 py-2 rounded-lg text-base font-semibold <?= $currentPage === 'historico.php' ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-100' ?>">Histórico & Salvos</a>
            <a href="exercicios.php" class="block px-3 py-2 rounded-lg text-base font-semibold <?= $currentPage === 'exercicios.php' ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-100' ?>">Exercícios</a>
            <a href="estudos.php" class="block px-3 py-2 rounded-lg text-base font-semibold <?= $currentPage === 'estudos.php' ? 'bg-blue-50 text-blue-700' : 'text-slate-700 hover:bg-slate-100' ?>">Estudos & Lavoisier</a>
            <?php if ($currentUser): ?>
                <div class="pt-3 mt-3 border-t border-slate-100 flex items-center justify-between">
                    <div>
                        <div class="font-bold text-slate-800 text-sm"><?= htmlspecialchars($currentUser['nome']) ?></div>
                        <div class="text-xs text-slate-500"><?= htmlspecialchars($currentUser['email']) ?></div>
                    </div>
                    <a href="login.php?logout=1" class="text-xs font-semibold text-rose-600 bg-rose-50 px-3 py-1.5 rounded-lg">Sair</a>
                </div>
            <?php endif; ?>
        </div>
    </header>

    <script>
        document.getElementById('mobileMenuBtn')?.addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
    </script>

    <!-- Main Page Content Starts Here -->
    <main class="flex-grow">
