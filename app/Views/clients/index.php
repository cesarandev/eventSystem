<section class="section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">CRM</p>
            <h1>Clientes</h1>
        </div>
        <input class="search" data-table-search="clientsTable" type="search" placeholder="Buscar cliente, NIT, ciudad">
    </div>

    <div class="grid-two">
        <form class="panel form-grid" method="post" action="/clientes">
            <h2>Crear cliente</h2>
            <label>Nombre o razon social <input name="name" required></label>
            <label>Tipo documento
                <select name="document_type"><option>NIT</option><option>CC</option><option>CE</option></select>
            </label>
            <label>Numero <input name="document_number" required></label>
            <label>Contacto <input name="contact_name"></label>
            <label>Telefono <input name="phone"></label>
            <label>Email <input name="email" type="email"></label>
            <label>Ciudad <input name="city"></label>
            <label>Direccion <input name="address"></label>
            <label>Segmento
                <select name="segment"><option>Empresa</option><option>Institucional</option><option>Persona natural</option><option>Proveedor</option></select>
            </label>
            <label>Estado
                <select name="status"><option value="prospecto">Prospecto</option><option value="activo">Activo</option><option value="recurrente">Recurrente</option><option value="inactivo">Inactivo</option></select>
            </label>
            <label class="span-2">Notas <textarea name="notes"></textarea></label>
            <button class="primary-btn">Guardar cliente</button>
        </form>

        <div class="table-wrap">
            <table id="clientsTable">
                <thead><tr><th>Cliente</th><th>Contacto</th><th>Ciudad</th><th>Estado</th></tr></thead>
                <tbody>
                <?php foreach ($clients as $client): ?>
                    <tr>
                        <td><strong><?= e($client['name']) ?></strong><small><?= e($client['document_type']) ?> <?= e($client['document_number']) ?></small></td>
                        <td><?= e($client['contact_name']) ?><small><?= e($client['phone']) ?> <?= e($client['email']) ?></small></td>
                        <td><?= e($client['city']) ?></td>
                        <td><span class="status"><?= e($client['status']) ?></span></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
