<!-- ── Page header ──────────────────────────────────────── -->
<div class="flex items-start justify-between gap-6 mb-8">
    <div>
        <p class="text-xs font-semibold text-indigo-500 uppercase tracking-widest mb-1">Ventas</p>
        <h1 class="text-3xl font-bold text-slate-900">Cotizaciones</h1>
        <p class="text-slate-500 text-sm mt-1">Pipeline de ventas y seguimiento de propuestas</p>
    </div>
    <div class="pt-1 shrink-0">
        <button data-open-modal="quoteModal" class="btn-primary text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nueva cotización
        </button>
    </div>
</div>

<!-- ── Quotes board ─────────────────────────────────────── -->
<?php if (empty($quotes)): ?>
    <div class="card flex flex-col items-center justify-center py-20 text-center">
        <svg class="w-12 h-12 text-slate-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        <p class="text-slate-400 text-sm">Sin cotizaciones registradas</p>
        <button data-open-modal="quoteModal" class="btn-primary text-sm mt-4">Crear primera cotización</button>
    </div>
<?php else: ?>
<div class="grid grid-cols-2 gap-5 xl:grid-cols-3 2xl:grid-cols-4">
    <?php foreach ($quotes as $q): ?>
        <div class="card p-5 flex flex-col gap-3 hover:shadow-md transition-shadow">
            <div class="flex items-start justify-between gap-2">
                <span class="font-mono text-xs text-slate-400 bg-slate-50 px-2 py-1 rounded-lg"><?= e($q['code']) ?></span>
                <?= statusBadge($q['status']) ?>
            </div>

            <div class="flex-1">
                <h3 class="font-bold text-slate-900 text-base leading-snug"><?= e($q['event_name']) ?></h3>
                <p class="text-slate-500 text-sm mt-1"><?= e($q['client_name']) ?></p>
                <?php if ($q['event_date']): ?>
                    <p class="text-xs text-slate-400 mt-1">
                        <svg class="w-3.5 h-3.5 inline -mt-0.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <?= e(date('d M Y', strtotime($q['event_date']))) ?>
                    </p>
                <?php endif; ?>
            </div>

            <div>
                <div class="flex items-center justify-between mb-2 text-xs text-slate-500">
                    <span>Probabilidad</span>
                    <span class="font-semibold text-slate-700"><?= e($q['probability']) ?>%</span>
                </div>
                <div class="progress-track">
                    <div class="progress-fill" style="width: <?= e($q['probability']) ?>%"></div>
                </div>
            </div>

            <div class="flex items-center justify-between pt-3 border-t border-slate-100">
                <span class="text-lg font-bold text-slate-900"><?= money($q['total']) ?></span>
                <a class="btn-ghost text-xs" href="/cotizaciones/editar?id=<?= e($q['id']) ?>">Editar</a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- ── Modal: create / edit ────────────────────────────── -->
<dialog id="quoteModal" class="modal">
    <div class="modal-inner">
        <div class="modal-header">
            <div>
                <h2 class="modal-title"><?= e($formTitle) ?></h2>
                <p class="modal-subtitle">Propuesta comercial con IVA 19% automático</p>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('quoteModal')">✕</button>
        </div>

        <form method="post" action="<?= e($formAction) ?>">
            <?php if ($quote !== null): ?><input type="hidden" name="id" value="<?= e($quote['id']) ?>"><?php endif; ?>

            <div class="modal-body">
                <div class="form-grid">
                    <label>
                        <span class="form-label">Cliente <span class="text-red-400">*</span></span>
                        <select class="form-select" name="client_id" required>
                            <?php foreach ($clients as $cl): ?>
                                <option value="<?= e($cl['id']) ?>" <?= (int)($quote['client_id'] ?? 0) === (int)$cl['id'] ? 'selected' : '' ?>><?= e($cl['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span class="form-label">Código</span>
                        <input class="form-input" name="code" value="<?= e($quote['code'] ?? ('COT-' . date('YmdHis'))) ?>">
                    </label>

                    <label class="span-2">
                        <span class="form-label">Nombre del evento <span class="text-red-400">*</span></span>
                        <input class="form-input" name="event_name" value="<?= e($quote['event_name'] ?? '') ?>" required placeholder="Ej. Festival empresarial Colpatria 2026">
                    </label>

                    <label>
                        <span class="form-label">Fecha del evento</span>
                        <input class="form-input" name="event_date" type="date" value="<?= e($quote['event_date'] ?? '') ?>">
                    </label>

                    <label>
                        <span class="form-label">Válida hasta</span>
                        <input class="form-input" name="valid_until" type="date" value="<?= e($quote['valid_until'] ?? '') ?>">
                    </label>

                    <label>
                        <span class="form-label">Subtotal <span class="text-red-400">*</span></span>
                        <input class="form-input" name="subtotal" type="number" min="0" step="1000" value="<?= e($quote['subtotal'] ?? '') ?>" required placeholder="0">
                    </label>

                    <label>
                        <span class="form-label">Descuento</span>
                        <input class="form-input" name="discount" type="number" min="0" step="1000" value="<?= e($quote['discount'] ?? 0) ?>" placeholder="0">
                    </label>

                    <label>
                        <span class="form-label">Estado</span>
                        <select class="form-select" name="status">
                            <?php foreach (['borrador' => 'Borrador', 'enviada' => 'Enviada', 'negociacion' => 'Negociación', 'aprobada' => 'Aprobada', 'perdida' => 'Perdida'] as $val => $lbl): ?>
                                <option value="<?= e($val) ?>" <?= ($quote['status'] ?? 'borrador') === $val ? 'selected' : '' ?>><?= e($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span class="form-label">Probabilidad %</span>
                        <input class="form-input" name="probability" type="number" min="0" max="100" value="<?= e($quote['probability'] ?? 50) ?>">
                    </label>

                    <label class="span-2">
                        <span class="form-label">Notas</span>
                        <textarea class="form-textarea" name="notes" placeholder="Condiciones especiales, requerimientos del cliente…"><?= e($quote['notes'] ?? '') ?></textarea>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <?php if ($quote !== null): ?>
                    <a class="btn-secondary text-sm" href="/cotizaciones">Cancelar</a>
                <?php endif; ?>
                <button type="submit" class="btn-primary text-sm"><?= e($submitLabel) ?></button>
            </div>
        </form>
    </div>
</dialog>

<?php if ($quote !== null): ?>
<script>document.addEventListener('DOMContentLoaded', () => openModal('quoteModal'));</script>
<?php endif; ?>
