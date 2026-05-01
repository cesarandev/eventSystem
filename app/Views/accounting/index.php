<?php
$balance       = $income - $expenses;
$balanceColor  = $balance >= 0 ? '#059669' : '#dc2626';
$incomeWidth   = ($income + $expenses) > 0 ? ($income / ($income + $expenses)) * 100 : 50;
?>

<!-- ══ MODULE HEADER ═════════════════════════════════════ -->
<div class="module-header">
    <div class="module-header-bg"></div>
    <div class="flex items-center justify-between gap-6">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest mb-2" style="color: #6366f1;">Colombia</p>
            <h1 class="text-2xl font-extrabold text-slate-900">Contabilidad</h1>
            <p class="text-slate-500 text-sm mt-1">Registro contable, IVA, retenciones y flujo de caja</p>
        </div>
        <button data-open-modal="accountingModal" class="btn-primary shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo movimiento
        </button>
    </div>
</div>

<!-- ══ KPI METRICS ═══════════════════════════════════════ -->
<div class="grid gap-5 mb-7" style="grid-template-columns: repeat(4, 1fr);">

    <div class="metric-card">
        <div class="accent-line" style="background: linear-gradient(90deg, #10b981, #059669);"></div>
        <div class="accent-orb" style="background: #10b981;"></div>
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-500 text-sm font-medium">Ingresos</span>
            <div style="width:36px;height:36px;border-radius:10px;background:#ecfdf5;display:flex;align-items:center;justify-content:center;">
                <svg class="w-5 h-5" fill="none" stroke="#10b981" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black text-slate-900"><?= money($income) ?></p>
        <p class="text-xs text-slate-400 mt-1">Facturación y anticipos</p>
    </div>

    <div class="metric-card">
        <div class="accent-line" style="background: linear-gradient(90deg, #ef4444, #dc2626);"></div>
        <div class="accent-orb" style="background: #ef4444;"></div>
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-500 text-sm font-medium">Egresos</span>
            <div style="width:36px;height:36px;border-radius:10px;background:#fef2f2;display:flex;align-items:center;justify-content:center;">
                <svg class="w-5 h-5" fill="none" stroke="#ef4444" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black text-slate-900"><?= money($expenses) ?></p>
        <p class="text-xs text-slate-400 mt-1">Costos y gastos</p>
    </div>

    <div class="metric-card">
        <div class="accent-line" style="background: linear-gradient(90deg, #f59e0b, #d97706);"></div>
        <div class="accent-orb" style="background: #f59e0b;"></div>
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-500 text-sm font-medium">IVA generado</span>
            <div style="width:36px;height:36px;border-radius:10px;background:#fffbeb;display:flex;align-items:center;justify-content:center;">
                <svg class="w-5 h-5" fill="none" stroke="#f59e0b" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black text-slate-900"><?= money($taxes) ?></p>
        <p class="text-xs text-slate-400 mt-1">Control tributario 19%</p>
    </div>

    <div class="metric-card">
        <div class="accent-line" style="background: linear-gradient(90deg, #8b5cf6, #7c3aed);"></div>
        <div class="accent-orb" style="background: #8b5cf6;"></div>
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-500 text-sm font-medium">Retenciones</span>
            <div style="width:36px;height:36px;border-radius:10px;background:#f5f3ff;display:flex;align-items:center;justify-content:center;">
                <svg class="w-5 h-5" fill="none" stroke="#8b5cf6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-black text-slate-900"><?= money($withholdings) ?></p>
        <p class="text-xs text-slate-400 mt-1">ReteFuente · ReteIVA · ReteICA</p>
    </div>
</div>

<!-- ── Income vs Expense bar ────────────────────────────── -->
<div class="card mb-7" style="padding: 20px 24px;">
    <div class="flex items-center justify-between mb-3">
        <div class="flex items-center gap-4">
            <div class="flex items-center gap-2">
                <div style="width:10px;height:10px;border-radius:3px;background:#10b981;"></div>
                <span class="text-sm font-semibold text-slate-700">Ingresos <?= money($income) ?></span>
            </div>
            <div class="flex items-center gap-2">
                <div style="width:10px;height:10px;border-radius:3px;background:#ef4444;"></div>
                <span class="text-sm font-semibold text-slate-700">Egresos <?= money($expenses) ?></span>
            </div>
        </div>
        <div>
            <span class="text-sm font-bold" style="color:<?= $balanceColor ?>;">
                Balance: <?= money(abs($balance)) ?> <?= $balance >= 0 ? '↑' : '↓' ?>
            </span>
        </div>
    </div>
    <div style="height:10px;background:#fef2f2;border-radius:999px;overflow:hidden;">
        <div style="height:100%;width:<?= number_format($incomeWidth, 2) ?>%;background:linear-gradient(90deg,#10b981,#059669);border-radius:999px;transition:width 0.8s ease;"></div>
    </div>
    <div class="flex justify-between mt-1.5">
        <span class="text-xs text-slate-400"><?= number_format($incomeWidth, 1) ?>% ingresos</span>
        <span class="text-xs text-slate-400"><?= number_format(100 - $incomeWidth, 1) ?>% egresos</span>
    </div>
</div>

<!-- ── Content grid ─────────────────────────────────────── -->
<div class="grid gap-6" style="grid-template-columns: 1.6fr 1fr;">

    <!-- Movements table -->
    <div class="card overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5" style="border-bottom: 1px solid #f8fafc;">
            <div>
                <h2 class="text-base font-bold text-slate-900">Movimientos contables</h2>
                <p class="text-xs text-slate-400 mt-0.5"><?= count($entries) ?> registros · Base causación</p>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Tipo</th>
                        <th>Tercero</th>
                        <th>Documento</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($entries as $row): ?>
                    <tr>
                        <td class="text-slate-500 text-xs font-mono"><?= e($row['entry_date']) ?></td>
                        <td>
                            <?= statusBadge($row['type']) ?>
                            <p class="text-xs text-slate-400 mt-1"><?= e($row['category']) ?></p>
                        </td>
                        <td>
                            <p class="font-semibold text-slate-900 text-sm"><?= e($row['third_party']) ?></p>
                            <p class="text-xs text-slate-400 mt-0.5" style="max-width:160px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?= e($row['description']) ?></p>
                        </td>
                        <td class="font-mono text-xs text-slate-500"><?= e($row['document_number']) ?></td>
                        <td class="font-bold text-slate-900"><?= money($row['total']) ?></td>
                        <td><?= statusBadge($row['payment_status']) ?></td>
                        <td class="text-right">
                            <a class="btn-ghost text-xs" href="/contabilidad/editar?id=<?= e($row['id']) ?>">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                Editar
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($entries)): ?>
                    <tr><td colspan="7" class="text-center text-slate-400 py-12 text-sm">Sin movimientos registrados</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Compliance grid -->
    <div class="space-y-4">
        <?php
        $compliance = [
            ['#eef2ff','#6366f1','Facturación DIAN','Prefijos, resolución, CUFE, notas crédito/débito y validación electrónica.','M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
            ['#fffbeb','#d97706','Impuestos','IVA 19%, retenciones, ICA/ReteICA por municipio, autorreteción y conciliación por tercero.','M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z'],
            ['#ecfdf5','#059669','Nómina y prestadores','Nómina electrónica, seguridad social, honorarios, documento soporte y costos.','M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
            ['#f5f3ff','#7c3aed','Cartera y flujo','Anticipos, saldos por evento, edades de cartera, pagos a proveedores y utilidad por proyecto.','M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3'],
        ];
        foreach ($compliance as [$bg, $color, $title, $desc, $path]):
        ?>
        <div class="card" style="padding: 18px 20px;">
            <div class="flex items-start gap-3">
                <div style="width:40px;height:40px;border-radius:12px;background:<?= $bg ?>;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                    <svg class="w-5 h-5" fill="none" stroke="<?= $color ?>" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="<?= $path ?>"/>
                    </svg>
                </div>
                <div>
                    <p class="font-bold text-slate-900 text-sm"><?= $title ?></p>
                    <p class="text-slate-500 text-xs mt-1 leading-relaxed"><?= $desc ?></p>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ══ MODAL ════════════════════════════════════════════ -->
<dialog id="accountingModal" class="modal">
    <div class="modal-inner">
        <div class="modal-header">
            <div class="flex items-start gap-3">
                <div class="modal-header-icon">
                    <svg class="w-5 h-5" fill="none" stroke="#6366f1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <div>
                    <h2 class="modal-title"><?= e($formTitle) ?></h2>
                    <p class="modal-subtitle">Ingreso o egreso con base, IVA y retenciones</p>
                </div>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('accountingModal')">✕</button>
        </div>

        <form method="post" action="<?= e($formAction) ?>">
            <?php if ($entry !== null): ?>
                <input type="hidden" name="id" value="<?= e($entry['id']) ?>">
            <?php endif; ?>

            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-section">
                        <p class="form-section-title">Identificación del movimiento</p>
                    </div>

                    <label>
                        <span class="form-label">Fecha <span class="text-red-400">*</span></span>
                        <input class="form-input" name="entry_date" type="date" value="<?= e($entry['entry_date'] ?? date('Y-m-d')) ?>" required>
                    </label>

                    <label>
                        <span class="form-label">Tipo de movimiento</span>
                        <select class="form-select" name="type">
                            <?php foreach (['ingreso' => 'Ingreso — Entrada de dinero', 'egreso' => 'Egreso — Salida de dinero'] as $val => $lbl): ?>
                                <option value="<?= e($val) ?>" <?= ($entry['type'] ?? 'ingreso') === $val ? 'selected' : '' ?>><?= e($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span class="form-label">Categoría <span class="text-red-400">*</span></span>
                        <input class="form-input" name="category" value="<?= e($entry['category'] ?? '') ?>" required placeholder="Factura electrónica, nómina, honorario…">
                    </label>

                    <label>
                        <span class="form-label">Tercero <span class="text-red-400">*</span></span>
                        <input class="form-input" name="third_party" value="<?= e($entry['third_party'] ?? '') ?>" required placeholder="Nombre empresa o persona">
                    </label>

                    <label>
                        <span class="form-label">Número de documento</span>
                        <input class="form-input" name="document_number" value="<?= e($entry['document_number'] ?? '') ?>" placeholder="FEV-0001">
                    </label>

                    <label>
                        <span class="form-label">Estado de pago</span>
                        <select class="form-select" name="payment_status">
                            <?php foreach (['pendiente' => 'Pendiente', 'pagado' => 'Pagado', 'parcial' => 'Parcial', 'vencido' => 'Vencido'] as $val => $lbl): ?>
                                <option value="<?= e($val) ?>" <?= ($entry['payment_status'] ?? 'pendiente') === $val ? 'selected' : '' ?>><?= e($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <div class="form-section">
                        <p class="form-section-title">Valores</p>
                    </div>

                    <label>
                        <span class="form-label">Base <span class="text-red-400">*</span></span>
                        <input class="form-input" name="base_amount" type="number" min="0" step="1000" value="<?= e($entry['base_amount'] ?? '') ?>" required placeholder="0">
                    </label>

                    <label>
                        <span class="form-label">IVA / Impuesto</span>
                        <input class="form-input" name="tax_amount" type="number" min="0" step="1000" value="<?= e($entry['tax_amount'] ?? 0) ?>" placeholder="0">
                    </label>

                    <label>
                        <span class="form-label">Retención</span>
                        <input class="form-input" name="withholding_amount" type="number" min="0" step="1000" value="<?= e($entry['withholding_amount'] ?? 0) ?>" placeholder="0">
                    </label>

                    <label>
                        <span class="form-label">Total neto <span class="text-red-400">*</span></span>
                        <input class="form-input" name="total" type="number" min="0" step="1000" value="<?= e($entry['total'] ?? '') ?>" required placeholder="0">
                        <span class="form-hint">Base + IVA − Retención</span>
                    </label>

                    <label class="span-2">
                        <span class="form-label">Descripción</span>
                        <textarea class="form-textarea" name="description" placeholder="Detalle del movimiento contable, referencia interna…"><?= e($entry['description'] ?? '') ?></textarea>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <?php if ($entry !== null): ?>
                    <a class="btn-secondary" href="/contabilidad">Cancelar</a>
                <?php endif; ?>
                <button type="submit" class="btn-primary"><?= e($submitLabel) ?></button>
            </div>
        </form>
    </div>
</dialog>

<?php if ($entry !== null): ?>
<script>document.addEventListener('DOMContentLoaded', () => openModal('accountingModal'));</script>
<?php endif; ?>
