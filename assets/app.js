/* ── Modal helpers ─────────────────────────────────────── */
function openModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.showModal();
}

function closeModal(id) {
    const modal = document.getElementById(id);
    if (modal) modal.close();
}

// data-open-modal buttons
document.querySelectorAll('[data-open-modal]').forEach((btn) => {
    btn.addEventListener('click', () => openModal(btn.dataset.openModal));
});

// Click outside modal content = close
document.querySelectorAll('.modal').forEach((modal) => {
    modal.addEventListener('click', (e) => {
        if (e.target === modal) modal.close();
    });
});

// ── Table search ────────────────────────────────────────
document.querySelectorAll('[data-table-search]').forEach((input) => {
    input.addEventListener('input', () => {
        const table = document.getElementById(input.dataset.tableSearch);
        if (!table) return;
        const term = input.value.trim().toLowerCase();
        table.querySelectorAll('tbody tr').forEach((row) => {
            row.hidden = !!term && !row.textContent.toLowerCase().includes(term);
        });
    });
});

// ── Form submit feedback ────────────────────────────────
document.querySelectorAll('form').forEach((form) => {
    form.addEventListener('submit', () => {
        const btn = form.querySelector('.btn-primary[type="submit"], .btn-primary:not([type])');
        if (!btn) return;
        const orig = btn.textContent;
        btn.textContent = 'Guardando…';
        btn.disabled = true;
        setTimeout(() => { btn.textContent = orig; btn.disabled = false; }, 3000);
    });
});

// ── Dashboard period filter (static demo data) ───────────
const periodFilter = document.getElementById('periodFilter');
const metrics = {
    month:   ['$64.200.000',  '$72.100.000',  '32',  '18'],
    quarter: ['$184.600.000', '$126.900.000', '91',  '47'],
    year:    ['$612.400.000', '$238.700.000', '284', '156'],
};

periodFilter?.addEventListener('change', () => {
    document.querySelectorAll('.metric-value').forEach((node, i) => {
        node.textContent = metrics[periodFilter.value]?.[i] ?? node.textContent;
    });
});
