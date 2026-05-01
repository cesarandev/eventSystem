<!-- ── Page header ──────────────────────────────────────── -->
<div class="flex items-start justify-between gap-6 mb-8">
    <div>
        <p class="text-xs font-semibold text-indigo-500 uppercase tracking-widest mb-1">CRM</p>
        <h1 class="text-3xl font-bold text-slate-900">Clientes</h1>
        <p class="text-slate-500 text-sm mt-1">Empresas, personas naturales y proveedores</p>
    </div>
    <div class="flex items-center gap-3 pt-1 shrink-0">
        <input class="search-input" data-table-search="clientsTable" type="search" placeholder="Buscar cliente, NIT, ciudad…">
        <button data-open-modal="clientModal" class="btn-primary text-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuevo cliente
        </button>
    </div>
</div>

<!-- ── Clients table ────────────────────────────────────── -->
<div class="card overflow-hidden">
    <table class="data-table" id="clientsTable">
        <thead>
            <tr>
                <th>Cliente / Empresa</th>
                <th>Documento</th>
                <th>Contacto</th>
                <th>Ciudad</th>
                <th>Segmento</th>
                <th>Estado</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($clients as $row): ?>
            <tr>
                <td>
                    <span class="font-semibold text-slate-900"><?= e($row['name']) ?></span>
                    <?php if ($row['email']): ?>
                        <span class="block text-xs text-slate-400 mt-0.5"><?= e($row['email']) ?></span>
                    <?php endif; ?>
                </td>
                <td>
                    <span class="badge badge-gray"><?= e($row['document_type']) ?></span>
                    <span class="ml-1 text-slate-600 text-sm"><?= e($row['document_number']) ?></span>
                </td>
                <td>
                    <span class="text-slate-700"><?= e($row['contact_name']) ?></span>
                    <span class="block text-xs text-slate-400 mt-0.5"><?= e($row['phone']) ?></span>
                </td>
                <td class="text-slate-600"><?= e($row['city']) ?></td>
                <td><?= e($row['segment']) ?></td>
                <td><?= statusBadge($row['status']) ?></td>
                <td class="text-right">
                    <a class="btn-ghost text-xs" href="/clientes/editar?id=<?= e($row['id']) ?>">Editar</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (empty($clients)): ?>
            <tr><td colspan="7" class="text-center text-slate-400 py-12">Sin clientes registrados</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<!-- ── Modal: create / edit ────────────────────────────── -->
<dialog id="clientModal" class="modal">
    <div class="modal-inner">
        <div class="modal-header">
            <div>
                <h2 class="modal-title"><?= e($formTitle) ?></h2>
                <p class="modal-subtitle">Información fiscal y de contacto</p>
            </div>
            <button type="button" class="modal-close" onclick="closeModal('clientModal')">✕</button>
        </div>

        <form method="post" action="<?= e($formAction) ?>">
            <?php if ($client !== null): ?><input type="hidden" name="id" value="<?= e($client['id']) ?>"><?php endif; ?>

            <div class="modal-body">
                <div class="form-grid">
                    <label class="span-2">
                        <span class="form-label">Nombre o razón social <span class="text-red-400">*</span></span>
                        <input class="form-input" name="name" value="<?= e($client['name'] ?? '') ?>" required placeholder="Ej. Recreaciones del Valle S.A.S.">
                    </label>

                    <label>
                        <span class="form-label">Tipo de documento</span>
                        <select class="form-select" name="document_type">
                            <?php foreach (['NIT' => 'NIT', 'CC' => 'Cédula', 'CE' => 'Cédula extranjería'] as $val => $lbl): ?>
                                <option value="<?= e($val) ?>" <?= ($client['document_type'] ?? 'NIT') === $val ? 'selected' : '' ?>><?= e($lbl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </label>

                    <label>
                        <span class="form-label">Número de documento <span class="text-red-400">*</span></span>
                        <input class="form-input" name="document_number" value="<?= e($client['document_number'] ?? '') ?>" required placeholder="900.123.456-7">
                    </label>

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
                        <span class="form-label">Dirección</span>
                        <input class="form-input" name="address" value="<?= e($client['address'] ?? '') ?>" placeholder="Calle 123 # 45-67">
                    </label>

                    <label class="span-2">
                        <span class="form-label">Notas internas</span>
                        <textarea class="form-textarea" name="notes" placeholder="Observaciones sobre el cliente…"><?= e($client['notes'] ?? '') ?></textarea>
                    </label>
                </div>
            </div>

            <div class="modal-footer">
                <?php if ($client !== null): ?>
                    <a class="btn-secondary text-sm" href="/clientes">Cancelar</a>
                <?php endif; ?>
                <button type="submit" class="btn-primary text-sm"><?= e($submitLabel) ?></button>
            </div>
        </form>
    </div>
</dialog>

<?php if ($client !== null): ?>
<script>document.addEventListener('DOMContentLoaded', () => openModal('clientModal'));</script>
<?php endif; ?>
