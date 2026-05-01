<!-- ── Page header ──────────────────────────────────────── -->
<div class="flex items-start justify-between gap-6 mb-8">
    <div>
        <p class="text-xs font-semibold text-indigo-500 uppercase tracking-widest mb-1">Colombia</p>
        <h1 class="text-3xl font-bold text-slate-900">Contabilidad</h1>
        <p class="text-slate-500 text-sm mt-1">Registro contable, IVA, retenciones y flujo de caja</p>
    </div>
    <div class="pt-1 shrink-0">
        <button data-open-modal="accountingModal" class="btn-primary text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo movimiento
        </button>
    </div>
</div>

<!-- ── KPI metrics ──────────────────────────────────────── -->
<div class="grid grid-cols-4 gap-5 mb-8">

    <div class="metric-card">
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-500 text-sm font-medium">Ingresos</span>
            <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-900"><?= money($income) ?></p>
        <p class="text-xs text-slate-400 mt-1">Facturación y anticipos</p>
    </div>

    <div class="metric-card" style="--tw-before-bg: linear-gradient(90deg,#ef4444,#dc2626);">
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-500 text-sm font-medium">Egresos</span>
            <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-900"><?= money($expenses) ?></p>
        <p class="text-xs text-slate-400 mt-1">Costos y gastos</p>
    </div>

    <div class="metric-card">
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-500 text-sm font-medium">IVA generado</span>
            <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-900"><?= money($taxes) ?></p>
        <p class="text-xs text-slate-400 mt-1">Control tributario 19%</p>
    </div>

    <div class="metric-card">
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-500 text-sm font-medium">Retenciones</span>
            <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center">
                <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-slate-900"><?= money($withholdings) ?></p>
        <p class="text-xs text-slate-400 mt-1">ReteFuente, ReteIVA, ReteICA</p>
    </div>
</div>

<!-- ── Content grid ─────────────────────────────────────── -->
<div class="grid grid-cols-5 gap-6">

    <!-- Movements table -->
    <div class="col-span-3 card overflow-hidden">
        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100">
            <div>
                <h2 class="text-base font-bold text-slate-900">Movimientos contables</h2>
                <p class="text-xs text-slate-400 mt-0.5">Base causación</p>
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
                        <td class="text-slate-500 text-sm"><?= e($row['entry_date']) ?></td>
                        <td>
                            <?= statusBadge($row['type']) ?>
                            <span class="block text-xs text-slate-400 mt-1"><?= e($row['category']) ?></span>
                        </td>
                        <td>
                            <span class="font-medium text-slate-900"><?= e($row['third_party']) ?></span>
                            <span class="block text-xs text-slate-400 mt-0.5 truncate max-w-32"><?= e($row['description']) ?></span>
                        </td>
                        <td class="font-mono text-xs text-slate-500"><?= e($row['document_number']) ?></td>
                        <td class="font-semibold text-slate-900"><?= money($row['total']) ?></td>
                        <td><?= statusBadge($row['payment_status']) ?></td>
                        <td class="text-right">
                            <a class="btn-ghost text-xs" href="/contabilidad/editar?id=<?= e($row['id']) ?>">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php if (empty($entries)): ?>
                    <tr><td colspan="7" class="text-center text-slate-400 py-12">Sin movimientos registrados</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Compliance grid -->
    <div class="col-span-2 space-y-4">
        <div class="card p-5">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-indigo-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                </div>
                <div>
                    <p class="font-semibold text-slate-900 text-sm">Facturación DIAN</p>
                    <p class="text-slate-500 text-xs mt-1">Prefijos, resolución, CUFE, notas crédito/débito y validación electrónica.</p>
                </div>
            </div>
        </div>

        <div class="card p-5">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-amber-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m4.99 5h.01M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16l3.5-2 3.5 2 3.5-2 3.5 2z"/></svg>
                </div>
                <div>
                    <p class="font-semibold text-slate-900 text-sm">Impuestos</p>
                    <p class="text-slate-500 text-xs mt-1">IVA 19%, retenciones, ICA/ReteICA por municipio y autorretencion.</p>
                </div>
            </div>
        </div>

        <div class="card p-5">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <p class="font-semibold text-slate-900 text-sm">Nómina y prestadores</p>
                    <p class="text-slate-500 text-xs mt-1">Nómina electrónica, seguridad social, honorarios y documento soporte.</p>
                </div>
            </div>
        </div>

        <div class="card p-5">
            <div class="flex items-start gap-3">
                <div class="w-9 h-9 rounded-xl bg-violet-50 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-violet-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/></svg>
                </div>
                <div>
                    <p class="font-semibold text-slate-900 text-sm">Cartera y flujo de caja</p>
                    <p class="text-slate-500 text-xs mt-1">Anticipos, saldos por evento, edades de cartera y utilidad por proyecto.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- ── Modal: create / edit ────────────────────────────── -->
<dialog id="accountingModal" class="modal">
    <div class="modal-inner">
        <div class="modal-header">
            <div>
                <h2 class="modal-title"><?= e($formTitle) ?></h2>
                <p class="modal-subtitle">Ingreso o egreso con base, IVA y retenciones</p>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('accountingModal')">✕</button>
        </div>

        <form method="post" action="<?= e($formAction) ?>">
            <?php if ($entry !== null): ?><input type="hidden" name="id" value="<?= e($entry['id']) ?>"><?php endif; ?>

            <div class="modal-body">
                <div class="form-grid">
                    <label>
                        <span class="form-label">Fecha <span class="text-red-400">*</span></span>
                        <input class="form-input" name="entry_date" type="date" value="<?= e($entry['entry_date'] ?? date('Y-m-d')) ?>" required>
                    </label>

                    <label>
                        <span class="form-label">Tipo</span>
                        <select class="form-select" name="type">
                            <?php foreach (['ingreso' => 'Ingreso', 'egreso' => 'Egreso'] as $val => $lbl): ?>
                                <option value="<?= e($val) ?>" <?= ($entry['type'] ?? 'ingreso') === $val ? 'selected' : '' ?>><?= e($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span class="form-label">Categoría <span class="text-red-400">*</span></span>
                        <input class="form-input" name="category" value="<?= e($entry['category'] ?? '') ?>" required placeholder="Factura electrónica, nómina…">
                    </label>

                    <label>
                        <span class="form-label">Tercero <span class="text-red-400">*</span></span>
                        <input class="form-input" name="third_party" value="<?= e($entry['third_party'] ?? '') ?>" required placeholder="Empresa o persona">
                    </label>

                    <label>
                        <span class="form-label">Base <span class="text-red-400">*</span></span>
                        <input class="form-input" name="base_amount" type="number" min="0" step="1000" value="<?= e($entry['base_amount'] ?? '') ?>" required placeholder="0">
                    </label>

                    <label>
                        <span class="form-label">IVA / impuesto</span>
                        <input class="form-input" name="tax_amount" type="number" min="0" step="1000" value="<?= e($entry['tax_amount'] ?? 0) ?>" placeholder="0">
                    </label>

                    <label>
                        <span class="form-label">Retención</span>
                        <input class="form-input" name="withholding_amount" type="number" min="0" step="1000" value="<?= e($entry['withholding_amount'] ?? 0) ?>" placeholder="0">
                    </label>

                    <label>
                        <span class="form-label">Total <span class="text-red-400">*</span></span>
                        <input class="form-input" name="total" type="number" min="0" step="1000" value="<?= e($entry['total'] ?? '') ?>" required placeholder="0">
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

                    <label class="span-2">
                        <span class="form-label">Descripción</span>
                        <textarea class="form-textarea" name="description" placeholder="Detalle del movimiento contable…"><?= e($entry['description'] ?? '') ?></textarea>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <?php if ($entry !== null): ?>
                    <a class="btn-secondary text-sm" href="/contabilidad">Cancelar</a>
                <?php endif; ?>
                <button type="submit" class="btn-primary text-sm"><?= e($submitLabel) ?></button>
            </div>
        </form>
    </div>
</dialog>

<?php if ($entry !== null): ?>
<script>document.addEventListener('DOMContentLoaded', () => openModal('accountingModal'));</script>
<?php endif; ?>
