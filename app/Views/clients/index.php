<!-- ══ MODULE HEADER ═════════════════════════════════════ -->
<div class="module-header">
    <div class="module-header-bg"></div>
    <div class="flex items-center justify-between gap-6">
        <div>
            <p class="text-xs font-semibold uppercase tracking-widest mb-2"
               style="color: #6366f1; letter-spacing: 0.1em;">CRM</p>
            <h1 class="text-2xl font-extrabold text-slate-900 leading-tight">Clientes</h1>
            <p class="text-slate-500 text-sm mt-1">Empresas, personas naturales y proveedores</p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <input class="search-input" data-table-search="clientsTable"
                   type="search" placeholder="Buscar cliente, NIT, ciudad…">
            <button data-open-modal="clientModal" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Nuevo cliente
            </button>
        </div>
    </div>

    <!-- Stats strip -->
    <?php
    $total     = count($clients);
    $activos   = count(array_filter($clients, fn($c) => $c['status'] === 'activo'));
    $prospectos= count(array_filter($clients, fn($c) => $c['status'] === 'prospecto'));
    $recurrentes=count(array_filter($clients, fn($c) => $c['status'] === 'recurrente'));
    ?>
    <div class="flex gap-6 mt-6 pt-5" style="border-top: 1px solid #f1f5f9;">
        <div><p class="text-xl font-extrabold text-slate-900"><?= $total ?></p><p class="text-xs text-slate-400 mt-0.5">Total</p></div>
        <div style="border-left: 1px solid #f1f5f9; padding-left: 24px;"><p class="text-xl font-extrabold text-emerald-600"><?= $activos ?></p><p class="text-xs text-slate-400 mt-0.5">Activos</p></div>
        <div style="border-left: 1px solid #f1f5f9; padding-left: 24px;"><p class="text-xl font-extrabold text-amber-600"><?= $prospectos ?></p><p class="text-xs text-slate-400 mt-0.5">Prospectos</p></div>
        <div style="border-left: 1px solid #f1f5f9; padding-left: 24px;"><p class="text-xl font-extrabold text-indigo-600"><?= $recurrentes ?></p><p class="text-xs text-slate-400 mt-0.5">Recurrentes</p></div>
    </div>
</div>

<!-- ══ TABLE ════════════════════════════════════════════ -->
<div class="card overflow-hidden">
    <table class="data-table" id="clientsTable">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Documento</th>
                <th>Contacto</th>
                <th>Ciudad</th>
                <th>Segmento</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($clients as $row):
            $colors = ['avatar-indigo','avatar-violet','avatar-emerald','avatar-amber','avatar-rose','avatar-sky'];
            $avatarCls = $colors[abs(crc32($row['name'])) % count($colors)];
            $initial = mb_strtoupper(mb_substr($row['name'], 0, 1));
        ?>
            <tr>
                <td>
                    <div class="flex items-center gap-3">
                        <div class="avatar <?= $avatarCls ?>"><?= e($initial) ?></div>
                        <div>
                            <p class="font-semibold text-slate-900"><?= e($row['name']) ?></p>
                            <?php if ($row['email']): ?>
                                <p class="text-xs text-slate-400 mt-0.5"><?= e($row['email']) ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </td>
                <td>
                    <span class="badge badge-gray"><?= e($row['document_type']) ?></span>
                    <span class="ml-1.5 text-slate-600 text-sm font-mono"><?= e($row['document_number']) ?></span>
                </td>
                <td>
                    <p class="text-slate-700 text-sm"><?= e($row['contact_name']) ?></p>
                    <p class="text-xs text-slate-400 mt-0.5"><?= e($row['phone']) ?></p>
                </td>
                <td class="text-slate-600 text-sm"><?= e($row['city']) ?></td>
                <td>
                    <span class="text-slate-600 text-sm"><?= e($row['segment']) ?></span>
                </td>
                <td><?= statusBadge($row['status']) ?></td>
                <td class="text-right">
                    <a class="btn-ghost text-xs" href="/clientes/editar?id=<?= e($row['id']) ?>">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Editar
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($clients)): ?>
            <tr>
                <td colspan="7">
                    <div class="empty-state">
                        <div class="empty-state-icon">
                            <svg class="w-7 h-7 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <h3>Sin clientes registrados</h3>
                        <p>Agrega tu primer cliente para comenzar a gestionar el CRM.</p>
                        <button data-open-modal="clientModal" class="btn-primary">+ Agregar cliente</button>
                    </div>
                </td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- ══ MODAL ════════════════════════════════════════════ -->
<dialog id="clientModal" class="modal">
    <div class="modal-inner">
        <div class="modal-header">
            <div class="flex items-start gap-3">
                <div class="modal-header-icon">
                    <svg class="w-5 h-5" fill="none" stroke="#6366f1" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.75" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h2 class="modal-title"><?= e($formTitle) ?></h2>
                    <p class="modal-subtitle">Información fiscal, contacto y CRM</p>
                </div>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('clientModal')">✕</button>
        </div>

        <form method="post" action="<?= e($formAction) ?>">
            <?php if ($client !== null): ?>
                <input type="hidden" name="id" value="<?= e($client['id']) ?>">
            <?php endif; ?>

            <div class="modal-body">
                <div class="form-grid">

                    <!-- Sección: datos empresa -->
                    <div class="form-section">
                        <p class="form-section-title">Datos de la empresa</p>
                    </div>

                    <label class="span-2">
                        <span class="form-label">Nombre o razón social <span class="text-red-400">*</span></span>
                        <input class="form-input" name="name" value="<?= e($client['name'] ?? '') ?>" required placeholder="Ej. Recreaciones del Valle S.A.S.">
                    </label>

                    <label>
                        <span class="form-label">Tipo de documento</span>
                        <select class="form-select" name="document_type">
                            <?php foreach (['NIT' => 'NIT — Empresa', 'CC' => 'CC — Cédula', 'CE' => 'CE — Extranjería'] as $val => $lbl): ?>
                                <option value="<?= e($val) ?>" <?= ($client['document_type'] ?? 'NIT') === $val ? 'selected' : '' ?>><?= e($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span class="form-label">Número de documento <span class="text-red-400">*</span></span>
                        <input class="form-input" name="document_number" value="<?= e($client['document_number'] ?? '') ?>" required placeholder="900.123.456-7">
                    </label>

                    <!-- Sección: contacto -->
                    <div class="form-section">
                        <p class="form-section-title">Información de contacto</p>
                    </div>

                    <label>
                        <span class="form-label">Persona de contacto</span>
                        <input class="form-input" name="contact_name" value="<?= e($client['contact_name'] ?? '') ?>" placeholder="Nombre del contacto">
                    </label>

                    <label>
                        <span class="form-label">Teléfono</span>
                        <input class="form-input" name="phone" value="<?= e($client['phone'] ?? '') ?>" placeholder="3001234567">
                    </label>

                    <label>
                        <span class="form-label">Correo electrónico</span>
                        <input class="form-input" name="email" type="email" value="<?= e($client['email'] ?? '') ?>" placeholder="contacto@empresa.com">
                    </label>

                    <label>
                        <span class="form-label">Ciudad</span>
                        <input class="form-input" name="city" value="<?= e($client['city'] ?? '') ?>" placeholder="Bogotá">
                    </label>

                    <label class="span-2">
                        <span class="form-label">Dirección</span>
                        <input class="form-input" name="address" value="<?= e($client['address'] ?? '') ?>" placeholder="Calle 123 # 45-67, Piso 2">
                    </label>

                    <!-- Sección: clasificación -->
                    <div class="form-section">
                        <p class="form-section-title">Clasificación CRM</p>
                    </div>

                    <label>
                        <span class="form-label">Segmento</span>
                        <select class="form-select" name="segment">
                            <?php foreach (['Empresa', 'Institucional', 'Persona natural', 'Proveedor'] as $opt): ?>
                                <option value="<?= e($opt) ?>" <?= ($client['segment'] ?? 'Empresa') === $opt ? 'selected' : '' ?>><?= e($opt) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span class="form-label">Estado</span>
                        <select class="form-select" name="status">
                            <?php foreach (['prospecto' => 'Prospecto', 'activo' => 'Activo', 'recurrente' => 'Recurrente', 'inactivo' => 'Inactivo'] as $val => $lbl): ?>
                                <option value="<?= e($val) ?>" <?= ($client['status'] ?? 'prospecto') === $val ? 'selected' : '' ?>><?= e($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label class="span-2">
                        <span class="form-label">Notas internas</span>
                        <textarea class="form-textarea" name="notes" placeholder="Observaciones, historial, preferencias…"><?= e($client['notes'] ?? '') ?></textarea>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <?php if ($client !== null): ?>
                    <a class="btn-secondary text-sm" href="/clientes">Cancelar</a>
                <?php endif; ?>
                <button type="submit" class="btn-primary"><?= e($submitLabel) ?></button>
            </div>
        </form>
    </div>
</dialog>

<?php if ($client !== null): ?>
<script>document.addEventListener('DOMContentLoaded', () => openModal('clientModal'));</script>
<?php endif; ?>
