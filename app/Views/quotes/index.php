<?php
$totalPipeline = array_sum(array_map(fn($q) => $q['total'], $quotes));
$approved      = count(array_filter($quotes, fn($q) => $q['status'] === 'aprobada'));
$inProgress    = count(array_filter($quotes, fn($q) => in_array($q['status'], ['enviada','negociacion'])));
$drafts        = count(array_filter($quotes, fn($q) => $q['status'] === 'borrador'));

$stageOrder = ['borrador' => 0, 'enviada' => 1, 'negociacion' => 2, 'aprobada' => 3, 'perdida' => 4];
usort($quotes, fn($a, $b) => ($stageOrder[$a['status']] ?? 99) <=> ($stageOrder[$b['status']] ?? 99));
?>

<!-- ══ MODULE HEADER ═════════════════════════════════════ -->
<div class="module-header">
    <div class="module-header-bg"></div>
    <div class="flex items-center justify-between gap-6">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest mb-2" style="color: #6366f1;">Ventas</p>
            <h1 class="text-2xl font-extrabold text-slate-900">Cotizaciones</h1>
            <p class="text-slate-500 text-sm mt-1">Pipeline de ventas y seguimiento de propuestas</p>
        </div>
        <button data-open-modal="quoteModal" class="btn-primary shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nueva cotización
        </button>
    </div>

    <!-- Stats strip -->
    <div class="flex gap-6 mt-6 pt-5" style="border-top: 1px solid #f1f5f9;">
        <div><p class="text-xl font-extrabold text-slate-900"><?= money($totalPipeline) ?></p><p class="text-xs text-slate-400 mt-0.5">Pipeline total</p></div>
        <div style="border-left:1px solid #f1f5f9;padding-left:24px;"><p class="text-xl font-extrabold text-emerald-600"><?= $approved ?></p><p class="text-xs text-slate-400 mt-0.5">Aprobadas</p></div>
        <div style="border-left:1px solid #f1f5f9;padding-left:24px;"><p class="text-xl font-extrabold text-amber-600"><?= $inProgress ?></p><p class="text-xs text-slate-400 mt-0.5">En proceso</p></div>
        <div style="border-left:1px solid #f1f5f9;padding-left:24px;"><p class="text-xl font-extrabold text-slate-500"><?= $drafts ?></p><p class="text-xs text-slate-400 mt-0.5">Borradores</p></div>
        <div style="border-left:1px solid #f1f5f9;padding-left:24px;"><p class="text-xl font-extrabold text-slate-900"><?= count($quotes) ?></p><p class="text-xs text-slate-400 mt-0.5">Total</p></div>
    </div>
</div>

<!-- ══ CARDS ════════════════════════════════════════════ -->
<?php if (empty($quotes)): ?>
    <div class="card">
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            </div>
            <h3>Sin cotizaciones registradas</h3>
            <p>Crea tu primera propuesta comercial para comenzar el pipeline.</p>
            <button data-open-modal="quoteModal" class="btn-primary">+ Nueva cotización</button>
        </div>
    </div>
<?php else: ?>
<div class="grid gap-5" style="grid-template-columns: repeat(auto-fill, minmax(290px, 1fr));">
    <?php foreach ($quotes as $q):
        $stageWidths = ['borrador' => '10%', 'enviada' => '30%', 'negociacion' => '55%', 'aprobada' => '100%', 'perdida' => '0%'];
        $stageWidth = $stageWidths[$q['status']] ?? '0%';
        $colors = ['avatar-indigo','avatar-violet','avatar-emerald','avatar-amber','avatar-rose','avatar-sky'];
        $avatarCls = $colors[abs(crc32($q['client_name'])) % count($colors)];
        $initial = mb_strtoupper(mb_substr($q['client_name'], 0, 1));
    ?>
        <div class="card card-lift overflow-hidden" style="display:flex;flex-direction:column;">
            <!-- Stage progress line -->
            <div style="height: 3px; background: #f1f5f9;">
                <div style="height:100%; width:<?= $stageWidth ?>; background: linear-gradient(90deg, #6366f1, #8b5cf6); transition: width 0.5s ease;"></div>
            </div>

            <div style="padding: 18px 20px; flex:1; display:flex; flex-direction:column; gap:14px;">
                <!-- Header -->
                <div class="flex items-start justify-between gap-2">
                    <span class="font-mono text-xs text-slate-400 bg-slate-50 px-2 py-1 rounded-lg border border-slate-100"><?= e($q['code']) ?></span>
                    <?= statusBadge($q['status']) ?>
                </div>

                <!-- Event name -->
                <div>
                    <h3 class="font-bold text-slate-900 text-base leading-snug"><?= e($q['event_name']) ?></h3>
                    <?php if ($q['event_date']): ?>
                        <p class="text-xs text-slate-400 mt-1.5 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <?= e(date('d M Y', strtotime($q['event_date']))) ?>
                        </p>
                    <?php endif; ?>
                </div>

                <!-- Client -->
                <div class="flex items-center gap-2.5">
                    <div class="avatar <?= $avatarCls ?>" style="width:30px;height:30px;border-radius:8px;font-size:0.75rem;"><?= e($initial) ?></div>
                    <span class="text-slate-600 text-sm font-medium"><?= e($q['client_name']) ?></span>
                </div>

                <!-- Probability -->
                <div>
                    <div class="flex items-center justify-between mb-1.5">
                        <span class="text-xs text-slate-400">Probabilidad de cierre</span>
                        <span class="text-xs font-bold text-slate-700"><?= e($q['probability']) ?>%</span>
                    </div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width: <?= e($q['probability']) ?>%"></div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div style="padding: 14px 20px; border-top: 1px solid #f8fafc; display:flex; align-items:center; justify-content:space-between;">
                <div>
                    <p class="text-lg font-black text-slate-900"><?= money($q['total']) ?></p>
                    <?php if ($q['valid_until']): ?>
                        <p class="text-xs text-slate-400">Válida hasta <?= e(date('d M', strtotime($q['valid_until']))) ?></p>
                    <?php endif; ?>
                </div>
                <a class="btn-ghost text-xs" href="/cotizaciones/editar?id=<?= e($q['id']) ?>">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- ══ MODAL ════════════════════════════════════════════ -->
<dialog id="quoteModal" class="modal">
    <div class="modal-inner">
        <div class="modal-header">
            <div class="flex items-start gap-3">
                <div class="modal-header-icon">
                    <svg class="w-5 h-5" fill="none" stroke="#6366f1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
                <div>
                    <h2 class="modal-title"><?= e($formTitle) ?></h2>
                    <p class="modal-subtitle">IVA 19% calculado automáticamente sobre subtotal</p>
                </div>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('quoteModal')">✕</button>
        </div>

        <form method="post" action="<?= e($formAction) ?>">
            <?php if ($quote !== null): ?>
                <input type="hidden" name="id" value="<?= e($quote['id']) ?>">
            <?php endif; ?>

            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-section">
                        <p class="form-section-title">Información del evento</p>
                    </div>

                    <label>
                        <span class="form-label">Cliente <span class="text-red-400">*</span></span>
                        <select class="form-select" name="client_id" required>
                            <?php foreach ($clients as $cl): ?>
                                <option value="<?= e($cl['id']) ?>" <?= (int)($quote['client_id'] ?? 0) === (int)$cl['id'] ? 'selected' : '' ?>><?= e($cl['name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span class="form-label">Código de cotización</span>
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

                    <div class="form-section">
                        <p class="form-section-title">Valores económicos</p>
                    </div>

                    <label>
                        <span class="form-label">Subtotal <span class="text-red-400">*</span></span>
                        <input class="form-input" name="subtotal" type="number" min="0" step="1000" value="<?= e($quote['subtotal'] ?? '') ?>" required placeholder="0">
                        <span class="form-hint">IVA 19% se suma automáticamente</span>
                    </label>

                    <label>
                        <span class="form-label">Descuento</span>
                        <input class="form-input" name="discount" type="number" min="0" step="1000" value="<?= e($quote['discount'] ?? 0) ?>" placeholder="0">
                    </label>

                    <div class="form-section">
                        <p class="form-section-title">Estado comercial</p>
                    </div>

                    <label>
                        <span class="form-label">Estado</span>
                        <select class="form-select" name="status">
                            <?php foreach (['borrador' => 'Borrador', 'enviada' => 'Enviada', 'negociacion' => 'Negociación', 'aprobada' => 'Aprobada', 'perdida' => 'Perdida'] as $val => $lbl): ?>
                                <option value="<?= e($val) ?>" <?= ($quote['status'] ?? 'borrador') === $val ? 'selected' : '' ?>><?= e($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span class="form-label">Probabilidad de cierre %</span>
                        <input class="form-input" name="probability" type="number" min="0" max="100" value="<?= e($quote['probability'] ?? 50) ?>">
                    </label>

                    <label class="span-2">
                        <span class="form-label">Notas y condiciones</span>
                        <textarea class="form-textarea" name="notes" placeholder="Condiciones especiales, requerimientos, observaciones…"><?= e($quote['notes'] ?? '') ?></textarea>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <?php if ($quote !== null): ?>
                    <a class="btn-secondary" href="/cotizaciones">Cancelar</a>
                <?php endif; ?>
                <button type="submit" class="btn-primary"><?= e($submitLabel) ?></button>
            </div>
        </form>
    </div>
</dialog>

<?php if ($quote !== null): ?>
<script>document.addEventListener('DOMContentLoaded', () => openModal('quoteModal'));</script>
<?php endif; ?>
