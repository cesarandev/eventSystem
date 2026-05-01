<section class="section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">CRM</p>
            <h1>Clientes</h1>
        </div>
        <input class="search" data-table-search="clientsTable" type="search" placeholder="Buscar cliente, NIT, ciudad">
    </div>

    <div class="grid-two">
        <form class="panel form-grid" method="post" action="<?= e($formAction) ?>">
            <h2><?= e($formTitle) ?></h2>
            <?php if ($client !== null): ?><input type="hidden" name="id" value="<?= e($client['id']) ?>"><?php endif; ?>
            <label>Nombre o razon social <input name="name" value="<?= e($client['name'] ?? '') ?>" required></label>
            <label>Tipo documento
                <select name="document_type">
                    <?php foreach (['NIT', 'CC', 'CE'] as $option): ?><option value="<?= e($option) ?>" <?= ($client['document_type'] ?? 'NIT') === $option ? 'selected' : '' ?>><?= e($option) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label>Numero <input name="document_number" value="<?= e($client['document_number'] ?? '') ?>" required></label>
            <label>Contacto <input name="contact_name" value="<?= e($client['contact_name'] ?? '') ?>"></label>
            <label>Telefono <input name="phone" value="<?= e($client['phone'] ?? '') ?>"></label>
            <label>Email <input name="email" type="email" value="<?= e($client['email'] ?? '') ?>"></label>
            <label>Ciudad <input name="city" value="<?= e($client['city'] ?? '') ?>"></label>
            <label>Direccion <input name="address" value="<?= e($client['address'] ?? '') ?>"></label>
            <label>Segmento
                <select name="segment">
                    <?php foreach (['Empresa', 'Institucional', 'Persona natural', 'Proveedor'] as $option): ?><option value="<?= e($option) ?>" <?= ($client['segment'] ?? 'Empresa') === $option ? 'selected' : '' ?>><?= e($option) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label>Estado
                <select name="status">
                    <?php foreach (['prospecto' => 'Prospecto', 'activo' => 'Activo', 'recurrente' => 'Recurrente', 'inactivo' => 'Inactivo'] as $value => $label): ?><option value="<?= e($value) ?>" <?= ($client['status'] ?? 'prospecto') === $value ? 'selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?>
                </select>
            </label>
            <label class="span-2">Notas <textarea name="notes"><?= e($client['notes'] ?? '') ?></textarea></label>
            <button class="primary-btn"><?= e($submitLabel) ?></button>
            <?php if ($client !== null): ?><a class="secondary-btn span-2" href="/clientes">Cancelar edicion</a><?php endif; ?>
        </form>

        <div class="table-wrap">
            <table id="clientsTable">
                <thead><tr><th>Cliente</th><th>Contacto</th><th>Ciudad</th><th>Estado</th><th></th></tr></thead>
                <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><strong><?= e($client['name']) ?></strong><small><?= e($client['document_type']) ?> <?= e($client['document_number']) ?></small></td>
                        <td><?= e($client['contact_name']) ?><small><?= e($client['phone']) ?> <?= e($client['email']) ?></small></td>
                        <td><?= e($client['city']) ?></td>
                        <td><span class="status"><?= e($client['status']) ?></span></td>
                        <td><a class="text-btn" href="/clientes/editar?id=<?= e($client['id']) ?>">Editar</a></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
