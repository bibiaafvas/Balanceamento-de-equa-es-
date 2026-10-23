/**
 * BalanceQ - Frontend Application Logic (app.js)
 */

document.addEventListener('DOMContentLoaded', () => {
    initKeyboardShortcuts();
    initBalancerForm();
    initCopyButtons();
});

/**
 * Sistema de Notificações Toast
 */
function showToast(message, type = 'success') {
    const container = document.getElementById('toastContainer');
    if (!container) return;

    const toast = document.createElement('div');
    const bgColors = {
        success: 'bg-emerald-600 text-white',
        error: 'bg-rose-600 text-white',
        info: 'bg-blue-600 text-white'
    };

    toast.className = `pointer-events-auto flex items-center gap-2 px-4 py-3 rounded-2xl shadow-xl text-sm font-semibold transition-all duration-300 transform translate-y-2 opacity-0 ${bgColors[type] || bgColors.success}`;
    
    const iconSvg = type === 'success' 
        ? `<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`
        : `<svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`;

    toast.innerHTML = `${iconSvg} <span>${message}</span>`;
    container.appendChild(toast);

    // Animar entrada
    requestAnimationFrame(() => {
        toast.classList.remove('translate-y-2', 'opacity-0');
    });

    // Remover após 3.5s
    setTimeout(() => {
        toast.classList.add('opacity-0', 'translate-y-2');
        setTimeout(() => toast.remove(), 300);
    }, 3500);
}

/**
 * Teclado químico e inserção rápida de caracteres químicos
 */
function initKeyboardShortcuts() {
    window.insertAtCursor = function(char) {
        const input = document.getElementById('equationInput');
        if (!input) return;

        const start = input.selectionStart;
        const end = input.selectionEnd;
        const text = input.value;

        input.value = text.substring(0, start) + char + text.substring(end);
        input.focus();
        input.selectionStart = input.selectionEnd = start + char.length;
    };

    window.setEquationExample = function(eq) {
        const input = document.getElementById('equationInput');
        if (!input) return;
        input.value = eq;
        input.focus();
    };

    window.clearEquation = function() {
        const input = document.getElementById('equationInput');
        if (input) {
            input.value = '';
            input.focus();
        }
        const resultSection = document.getElementById('resultSection');
        if (resultSection) {
            resultSection.classList.add('hidden');
        }
        const errorSection = document.getElementById('errorSection');
        if (errorSection) {
            errorSection.classList.add('hidden');
        }
    };
}

/**
 * Cópia de texto para a área de transferência
 */
function initCopyButtons() {
    window.copyText = function(text, label = 'Equação copiada para a área de transferência!') {
        if (!text) return;
        navigator.clipboard.writeText(text).then(() => {
            showToast(label, 'success');
        }).catch(() => {
            showToast('Não foi possível copiar automaticamente.', 'error');
        });
    };
}

/**
 * Inicializador do Formulário do Balanceador
 */
function initBalancerForm() {
    const form = document.getElementById('balancerForm');
    if (!form) return;

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const input = document.getElementById('equationInput');
        const submitBtn = document.getElementById('submitBtn');
        const spinner = document.getElementById('btnSpinner');
        const btnText = document.getElementById('btnText');
        const modoRadio = document.querySelector('input[name="modo"]:checked');
        const modo = modoRadio ? modoRadio.value : 'automatico';

        const equation = input.value.trim();
        if (!equation) {
            showToast('Digite uma equação química para balancear.', 'error');
            input.focus();
            return;
        }

        // Estado de Carregamento
        if (submitBtn) submitBtn.disabled = true;
        if (spinner) spinner.classList.remove('hidden');
        if (btnText) btnText.textContent = 'Balanceando...';

        const errorSection = document.getElementById('errorSection');
        const resultSection = document.getElementById('resultSection');
        if (errorSection) errorSection.classList.add('hidden');

        try {
            const response = await fetch('api.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({
                    action: 'balance',
                    equation: equation,
                    modo: modo
                })
            });

            const data = await response.json();

            if (!response.ok || !data.success) {
                throw new Error(data.message || 'Ocorreu um erro ao balancear a equação.');
            }

            renderBalanceResult(data, modo);
            showToast('Equação balanceada com sucesso!', 'success');

        } catch (err) {
            if (errorSection) {
                const errorMsg = document.getElementById('errorMessage');
                if (errorMsg) errorMsg.textContent = err.message;
                errorSection.classList.remove('hidden');
            } else {
                showToast(err.message, 'error');
            }
            if (resultSection) resultSection.classList.add('hidden');
        } finally {
            if (submitBtn) submitBtn.disabled = false;
            if (spinner) spinner.classList.add('hidden');
            if (btnText) btnText.textContent = 'Balancear Equação';
        }
    });
}

/**
 * Renderiza o resultado do balanceamento na tela
 */
function renderBalanceResult(data, modo) {
    const resultSection = document.getElementById('resultSection');
    if (!resultSection) return;

    // Atualiza strings antes e depois
    const beforeEqEl = document.getElementById('beforeEquation');
    const balancedEqEl = document.getElementById('balancedEquationHtml');
    const balancedEqPlain = document.getElementById('balancedEquationPlain');

    if (beforeEqEl) beforeEqEl.textContent = data.before_str;
    if (balancedEqEl) balancedEqEl.innerHTML = data.balanced_html;
    if (balancedEqPlain) balancedEqPlain.value = data.balanced_str;

    // Configura botão de salvar/favorito
    const saveBtn = document.getElementById('saveEquationBtn');
    if (saveBtn) {
        if (data.history_id) {
            saveBtn.dataset.historyId = data.history_id;
            saveBtn.classList.remove('hidden');
            updateSaveButtonState(saveBtn, false);
        } else {
            // Usuário não logado
            saveBtn.dataset.historyId = '';
            saveBtn.classList.remove('hidden');
            saveBtn.innerHTML = `
                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                <span>Faça login com Gmail para Salvar</span>
            `;
            saveBtn.onclick = () => window.location.href = 'login.php?redirect=' + encodeURIComponent(window.location.href);
        }
    }

    // Tabela de Balanço de Átomos
    const atomsTableBody = document.getElementById('atomsTableBody');
    if (atomsTableBody) {
        atomsTableBody.innerHTML = '';
        for (const [el, info] of Object.entries(data.after_atoms)) {
            const tr = document.createElement('tr');
            tr.className = 'border-b border-slate-100 hover:bg-slate-50/70 transition-colors text-sm';
            tr.innerHTML = `
                <td class="py-2.5 px-4 font-bold text-slate-800 flex items-center gap-2">
                    <span class="w-7 h-7 rounded-lg bg-blue-100 text-blue-800 flex items-center justify-center text-xs font-mono font-bold">${el}</span>
                    <span>${info.name}</span>
                </td>
                <td class="py-2.5 px-4 text-center font-mono font-semibold text-slate-700">${info.reactants}</td>
                <td class="py-2.5 px-4 text-center font-mono font-semibold text-slate-700">${info.products}</td>
                <td class="py-2.5 px-4 text-center">
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-emerald-700 bg-emerald-100 px-2.5 py-0.5 rounded-full">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Conservado
                    </span>
                </td>
            `;
            atomsTableBody.appendChild(tr);
        }
    }

    // Seção Modo Manual: Passo a Passo
    const stepsContainer = document.getElementById('stepsContainer');
    const stepByStepCard = document.getElementById('stepByStepCard');

    if (modo === 'manual' && data.steps && data.steps.length > 0) {
        if (stepsContainer) {
            stepsContainer.innerHTML = '';
            data.steps.forEach(step => {
                const stepEl = document.createElement('div');
                stepEl.className = 'bg-white p-5 rounded-2xl border border-slate-200/80 shadow-sm space-y-3';
                
                let itemsHtml = '';
                if (step.items && step.items.length > 0) {
                    itemsHtml = `
                        <ul class="space-y-1.5 pl-4 text-sm text-slate-700 list-disc marker:text-emerald-500">
                            ${step.items.map(it => `<li>${it}</li>`).join('')}
                        </ul>
                    `;
                }

                stepEl.innerHTML = `
                    <div class="flex items-center gap-3">
                        <span class="w-8 h-8 rounded-xl bg-gradient-to-tr from-blue-600 to-indigo-600 text-white flex items-center justify-center font-black text-sm shrink-0">
                            ${step.num}
                        </span>
                        <h4 class="font-bold text-slate-900 text-base">${step.title}</h4>
                    </div>
                    <p class="text-sm text-slate-600 leading-relaxed">${step.desc}</p>
                    ${itemsHtml}
                `;
                stepsContainer.appendChild(stepEl);
            });
        }
        if (stepByStepCard) stepByStepCard.classList.remove('hidden');
    } else {
        if (stepByStepCard) stepByStepCard.classList.add('hidden');
    }

    // Exibe o card de resultados com scroll suave
    resultSection.classList.remove('hidden');
    resultSection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
}

/**
 * Alterna estado do botão de favoritar equação
 */
function updateSaveButtonState(btn, isSaved) {
    if (isSaved) {
        btn.classList.add('bg-amber-100', 'text-amber-800', 'border-amber-300');
        btn.classList.remove('bg-white', 'text-slate-700', 'border-slate-200');
        btn.innerHTML = `
            <svg class="w-4 h-4 fill-amber-500 text-amber-500" viewBox="0 0 24 24"><path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/></svg>
            <span>Salva nos Favoritos</span>
        `;
    } else {
        btn.classList.remove('bg-amber-100', 'text-amber-800', 'border-amber-300');
        btn.classList.add('bg-white', 'text-slate-700', 'border-slate-200');
        btn.innerHTML = `
            <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            <span>Salvar Equação</span>
        `;
    }
}

/**
 * Função global para alternar o salvamento de um item de histórico
 */
window.toggleSaveHistory = async function(historyId, triggerElement) {
    if (!historyId) {
        window.location.href = 'login.php?redirect=' + encodeURIComponent(window.location.href);
        return;
    }

    try {
        const response = await fetch('api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'toggle_save',
                id: historyId
            })
        });

        const data = await response.json();
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Erro ao salvar.');
        }

        if (triggerElement) {
            updateSaveButtonState(triggerElement, data.salvo);
        }
        showToast(data.message, 'success');
        
        // Se estiver na tela de histórico, pode atualizar visualmente
        const row = document.getElementById(`history-row-${historyId}`);
        if (row) {
            const star = row.querySelector('.star-icon');
            if (star) {
                if (data.salvo) {
                    star.classList.add('fill-amber-400', 'text-amber-400');
                    star.classList.remove('text-slate-300');
                } else {
                    star.classList.remove('fill-amber-400', 'text-amber-400');
                    star.classList.add('text-slate-300');
                }
            }
        }
    } catch (err) {
        showToast(err.message, 'error');
    }
};

/**
 * Deleta item do histórico
 */
window.deleteHistoryItem = async function(historyId) {
    if (!confirm('Deseja realmente remover esta equação do histórico?')) return;

    try {
        const response = await fetch('api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                action: 'delete_history',
                id: historyId
            })
        });

        const data = await response.json();
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Erro ao excluir.');
        }

        const el = document.getElementById(`history-row-${historyId}`);
        if (el) {
            el.remove();
        }
        showToast(data.message, 'success');
    } catch (err) {
        showToast(err.message, 'error');
    }
};

/**
 * Limpa histórico recente
 */
window.clearAllHistory = async function() {
    if (!confirm('Tem certeza que deseja limpar o histórico recente? As equações salvas com estrela serão mantidas.')) return;

    try {
        const response = await fetch('api.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ action: 'clear_history' })
        });

        const data = await response.json();
        if (!response.ok || !data.success) {
            throw new Error(data.message || 'Erro ao limpar histórico.');
        }

        showToast(data.message, 'success');
        setTimeout(() => window.location.reload(), 1000);
    } catch (err) {
        showToast(err.message, 'error');
    }
};
