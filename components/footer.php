    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-200 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-14">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                
                <!-- Coluna 1: Sobre -->
                <div class="md:col-span-2 space-y-3">
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-blue-600 to-emerald-500 flex items-center justify-center text-white font-bold text-base">
                            B
                        </div>
                        <span class="text-xl font-extrabold text-slate-800">BalanceQ</span>
                    </div>
                    <p class="text-sm text-slate-600 max-w-md leading-relaxed">
                        Plataforma educativa para cálculo e aprendizado de balanceamento de equações químicas. Desenvolvida com rigor científico, interface intuitiva e suporte pedagógico para Ensino Médio e Superior.
                    </p>
                    <div class="pt-2">
                        <blockquote class="text-xs text-slate-500 italic border-l-2 border-emerald-500 pl-3">
                            "Na natureza nada se cria, nada se perde, tudo se transforma."
                            <footer class="text-slate-400 font-medium not-italic mt-0.5">— Antoine Lavoisier</footer>
                        </blockquote>
                    </div>
                </div>

                <!-- Coluna 2: Navegação -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 mb-3">Navegação Rápida</h3>
                    <ul class="space-y-2 text-sm text-slate-600">
                        <li><a href="index.php" class="hover:text-blue-600 transition-smooth">Balanceador Químico</a></li>
                        <li><a href="historico.php" class="hover:text-blue-600 transition-smooth">Histórico & Salvos</a></li>
                        <li><a href="exercicios.php" class="hover:text-blue-600 transition-smooth">Quiz & Exercícios</a></li>
                        <li><a href="estudos.php" class="hover:text-blue-600 transition-smooth">Guia de Estudos (MACHO)</a></li>
                    </ul>
                </div>

                <!-- Coluna 3: Stack & Requisitos -->
                <div>
                    <h3 class="text-xs font-bold uppercase tracking-wider text-slate-900 mb-3">Stack Tecnológico</h3>
                    <div class="flex flex-wrap gap-1.5 text-xs">
                        <span class="px-2 py-1 rounded bg-blue-50 text-blue-700 font-semibold">PHP Nativo</span>
                        <span class="px-2 py-1 rounded bg-emerald-50 text-emerald-700 font-semibold">MySQL (PDO)</span>
                        <span class="px-2 py-1 rounded bg-cyan-50 text-cyan-700 font-semibold">Tailwind CSS</span>
                        <span class="px-2 py-1 rounded bg-slate-100 text-slate-700 font-semibold">Mobile First</span>
                        <span class="px-2 py-1 rounded bg-amber-50 text-amber-700 font-semibold">Login Gmail</span>
                    </div>
                    <p class="text-xs text-slate-400 mt-3">Segurança contra SQL Injection via PDO Prepared Statements.</p>
                </div>
            </div>

            <div class="border-t border-slate-100 mt-8 pt-6 flex flex-col sm:flex-row items-center justify-between text-xs text-slate-500 gap-4">
                <p>&copy; <?= date('Y') ?> BalanceQ. Todos os direitos reservados.</p>
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center gap-1.5 text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full font-medium">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        Sistema Operacional e Ativo
                    </span>
                </div>
            </div>
        </div>
    </footer>

    <!-- Global Toast Container -->
    <div id="toastContainer" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 max-w-sm pointer-events-none"></div>

    <script src="assets/js/app.js"></script>
</body>
</html>
