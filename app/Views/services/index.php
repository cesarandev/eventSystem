<?php
$totalSvcs  = count($services);
$available  = count(array_filter($services, fn($s) => $s['status'] === 'disponible'));
$highDemand = count(array_filter($services, fn($s) => $s['status'] === 'alta_demanda'));
$avgMargin  = $totalSvcs > 0
    ? array_sum(array_map(fn($s) => (float)$s['price'] > 0 ? (($s['price']-$s['cost'])/$s['price'])*100 : 0, $services)) / $totalSvcs
    : 0;

$catIconPath = fn(string $cat): string => match(true) {
    str_contains(strtolower($cat), 'inflable') || str_contains(strtolower($cat), 'atraccion') => 'M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    str_contains(strtolower($cat), 'show')     || str_contains(strtolower($cat), 'musica')    => 'M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3',
    default => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'
};
?>

<!-- ══ MODULE HEADER ═════════════════════════════════════ -->
<div class="module-header">
    <div class="module-header-bg"></div>
    <div class="flex items-center justify-between gap-6">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest mb-2" style="color: #6366f1;">Catálogo</p>
            <h1 class="text-2xl font-extrabold text-slate-900">Servicios</h1>
            <p class="text-slate-500 text-sm mt-1">Inventario comercial con precios y márgenes</p>
        </div>
        <button data-open-modal="serviceModal" class="btn-primary shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo servicio
        </button>
    </div>

    <!-- Stats strip -->
    <div class="flex gap-6 mt-6 pt-5" style="border-top: 1px solid #f1f5f9;">
        <div><p class="text-xl font-extrabold text-slate-900"><?= $totalSvcs ?></p><p class="text-xs text-slate-400 mt-0.5">Servicios</p></div>
        <div style="border-left:1px solid #f1f5f9;padding-left:24px;"><p class="text-xl font-extrabold text-emerald-600"><?= $available ?></p><p class="text-xs text-slate-400 mt-0.5">Disponibles</p></div>
        <div style="border-left:1px solid #f1f5f9;padding-left:24px;"><p class="text-xl font-extrabold text-amber-600"><?= $highDemand ?></p><p class="text-xs text-slate-400 mt-0.5">Alta demanda</p></div>
        <div style="border-left:1px solid #f1f5f9;padding-left:24px;"><p class="text-xl font-extrabold text-indigo-600"><?= number_format($avgMargin, 1, ',', '.') ?>%</p><p class="text-xs text-slate-400 mt-0.5">Margen promedio</p></div>
    </div>
</div>

<!-- ══ CARDS GRID ════════════════════════════════════════ -->
<?php if (empty($services)): ?>
    <div class="card">
        <div class="empty-state">
            <div class="empty-state-icon">
                <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <h3>Sin servicios registrados</h3>
            <p>Crea tu catálogo de servicios para comenzar a cotizar.</p>
            <button data-open-modal="serviceModal" class="btn-primary">+ Agregar servicio</button>
        </div>
    </div>
<?php else: ?>
<div class="grid gap-5" style="grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));">
    <?php foreach ($services as $svc):
        $margin = (float)$svc['price'] > 0 ? (($svc['price'] - $svc['cost']) / $svc['price']) * 100 : 0;
        $marginColor = $margin >= 40 ? '#10b981' : ($margin >= 20 ? '#f59e0b' : '#ef4444');
        $marginBg    = $margin >= 40 ? '#ecfdf5'  : ($margin >= 20 ? '#fffbeb'  : '#fef2f2');
        $marginText  = $margin >= 40 ? '#065f46'  : ($margin >= 20 ? '#92400e'  : '#991b1b');
        $catColors   = [
            'bg' => '#eef2ff', 'fg' => '#4338ca',
        ];
    ?>
        <div class="card card-lift overflow-hidden" style="display:flex;flex-direction:column;">
            <!-- Card header accent -->
            <div style="height: 4px; background: linear-gradient(90deg, #6366f1, #8b5cf6);"></div>

            <div style="padding: 20px 20px 0; flex: 1; display: flex; flex-direction: column; gap: 14px;">
                <!-- Top -->
                <div class="flex items-start justify-between gap-2">
                    <div class="flex items-center gap-2.5">
                        <div style="width:36px;height:36px;border-radius:10px;background:#eef2ff;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                            <svg class="w-5 h-5" fill="none" stroke="#6366f1" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="<?= $catIconPath($svc['category']) ?>"/>
                            </svg>
                        </div>
                        <span class="badge badge-indigo"><?= e($svc['category']) ?></span>
                    </div>
                    <?= statusBadge($svc['status']) ?>
                </div>

                <!-- Name & desc -->
                <div>
                    <h3 class="font-bold text-slate-900 text-base leading-tight"><?= e($svc['name']) ?></h3>
                    <p class="text-slate-500 text-sm mt-1.5 leading-relaxed" style="display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"><?= e($svc['description']) ?></p>
                </div>

                <!-- Price / margin -->
                <div class="flex items-end justify-between">
                    <div>
                        <p class="text-2xl font-black text-slate-900"><?= money($svc['price']) ?></p>
                        <p class="text-xs text-slate-400 mt-0.5">por <?= e($svc['billing_unit']) ?></p>
                    </div>
                    <div style="text-align:right;">
                        <p class="text-sm font-bold" style="color:<?= $marginText ?>;"><?= number_format($margin, 1, ',', '.') ?>% margen</p>
                        <p class="text-xs text-slate-400">Costo <?= money($svc['cost']) ?></p>
                    </div>
                </div>

                <!-- Margin bar -->
                <div>
                    <div class="progress-track">
                        <div class="progress-fill" style="width:<?= min(100, max(0, $margin)) ?>%; background:linear-gradient(90deg,<?= $marginColor ?>,<?= $marginColor ?>99);"></div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div style="padding: 14px 20px; margin-top: 4px; border-top: 1px solid #f8fafc; display:flex; align-items:center; justify-content:space-between;">
                <div class="flex items-center gap-1.5 text-xs text-slate-400">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    <?= e($svc['capacity']) ?> cupos
                </div>
                <a class="btn-ghost text-xs" href="/servicios/editar?id=<?= e($svc['id']) ?>">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Editar
                </a>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<!-- ══ MODAL ════════════════════════════════════════════ -->
<dialog id="serviceModal" class="modal">
    <div class="modal-inner">
        <div class="modal-header">
            <div class="flex items-start gap-3">
                <div class="modal-header-icon">
                    <svg class="w-5 h-5" fill="none" stroke="#6366f1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
                <div>
                    <h2 class="modal-title"><?= e($formTitle) ?></h2>
                    <p class="modal-subtitle">Precio, costo, capacidad y unidad de cobro</p>
                </div>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('serviceModal')">✕</button>
        </div>

        <form method="post" action="<?= e($formAction) ?>">
            <?php if ($service !== null): ?>
                <input type="hidden" name="id" value="<?= e($service['id']) ?>">
            <?php endif; ?>

            <div class="modal-body">
                <div class="form-grid">
                    <div class="form-section">
                        <p class="form-section-title">Identificación</p>
                    </div>

                    <label>
                        <span class="form-label">Nombre del servicio <span class="text-red-400">*</span></span>
                        <input class="form-input" name="name" value="<?= e($service['name'] ?? '') ?>" required placeholder="Ej. Inflable gigante">
                    </label>

                    <label>
                        <span class="form-label">Categoría <span class="text-red-400">*</span></span>
                        <input class="form-input" name="category" value="<?= e($service['category'] ?? '') ?>" required placeholder="Atracciones, shows, recreación">
                    </label>

                    <label class="span-2">
                        <span class="form-label">Descripción</span>
                        <textarea class="form-textarea" name="description" placeholder="Descripción del servicio, qué incluye, condiciones…"><?= e($service['description'] ?? '') ?></textarea>
                    </label>

                    <div class="form-section">
                        <p class="form-section-title">Precios y facturación</p>
                    </div>

                    <label>
                        <span class="form-label">Precio de venta <span class="text-red-400">*</span></span>
                        <input class="form-input" name="price" type="number" min="0" step="1000" value="<?= e($service['price'] ?? '') ?>" required placeholder="0">
                    </label>

                    <label>
                        <span class="form-label">Costo interno</span>
                        <input class="form-input" name="cost" type="number" min="0" step="1000" value="<?= e($service['cost'] ?? '') ?>" placeholder="0">
                        <span class="form-hint">Base para calcular margen</span>
                    </label>

                    <label>
                        <span class="form-label">Unidad de facturación</span>
                        <select class="form-select" name="billing_unit">
                            <?php foreach (['hora' => 'Por hora', 'dia' => 'Por día', 'evento' => 'Por evento', 'persona' => 'Por persona'] as $val => $lbl): ?>
                                <option value="<?= e($val) ?>" <?= ($service['billing_unit'] ?? 'evento') === $val ? 'selected' : '' ?>><?= e($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span class="form-label">Capacidad (cupos)</span>
                        <input class="form-input" name="capacity" type="number" min="1" value="<?= e($service['capacity'] ?? 1) ?>">
                    </label>

                    <div class="form-section">
                        <p class="form-section-title">Estado</p>
                    </div>

                    <label class="span-2">
                        <span class="form-label">Disponibilidad</span>
                        <select class="form-select" name="status">
                            <?php foreach (['disponible' => 'Disponible — Listo para contratar', 'alta_demanda' => 'Alta demanda — Agendar con anticipación', 'mantenimiento' => 'Mantenimiento — No disponible'] as $val => $lbl): ?>
                                <option value="<?= e($val) ?>" <?= ($service['status'] ?? 'disponible') === $val ? 'selected' : '' ?>><?= e($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <?php if ($service !== null): ?>
                    <a class="btn-secondary" href="/servicios">Cancelar</a>
                <?php endif; ?>
                <button type="submit" class="btn-primary"><?= e($submitLabel) ?></button>
            </div>
        </form>
    </div>
</dialog>

<?php if ($service !== null): ?>
<script>document.addEventListener('DOMContentLoaded', () => openModal('serviceModal'));</script>
<?php endif; ?>
