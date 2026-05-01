<section class="section">
    <div class="section-heading">
        <div>
            <p class="eyebrow">Colombia</p>
            <h1>Contabilidad y cumplimiento</h1>
        </div>
    </div>

    <div class="metric-grid">
        <article class="metric"><span>Ingresos</span><strong><?= money($income) ?></strong><small>Facturacion y anticipos</small></article>
        <article class="metric"><span>Egresos</span><strong><?= money($expenses) ?></strong><small>Costos y gastos</small></article>
        <article class="metric"><span>IVA generado/descontable</span><strong><?= money($taxes) ?></strong><small>Control tributario</small></article>
        <article class="metric"><span>Retenciones</span><strong><?= money($withholdings) ?></strong><small>ReteFuente, ReteIVA, ReteICA</small></article>
    </div>

    <div class="accounting-layout">
        <article class="panel">
            <div class="panel-header"><h2>Movimientos contables</h2><span>Base causacion</span></div>
            <div class="table-wrap compact">
                <table>
                    <thead><tr><th>Fecha</th><th>Tipo</th><th>Tercero</th><th>Documento</th><th>Total</th><th>Estado</th><th></th></tr></thead>
                    <tbody>
                    <?php foreach ($entries as $row): ?>
                        <tr>
                            <td><?= e($row['entry_date']) ?></td>
                            <td><?= e($row['type']) ?><small><?= e($row['category']) ?></small></td>
                            <td><?= e($row['third_party']) ?><small><?= e($row['description']) ?></small></td>
                            <td><?= e($row['document_number']) ?></td>
                            <td><?= money($row['total']) ?></td>
                            <td><span class="status"><?= e($row['payment_status']) ?></span></td>
                            <td><a class="text-btn" href="/contabilidad/editar?id=<?= e($row['id']) ?>">Editar</a></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </article>

        <div class="compliance-grid">
            <article><strong>Facturacion electronica DIAN</strong><p>Prefijos, resolucion, consecutivos, CUFE, notas credito/debito y validacion.</p></article>
            <article><strong>Impuestos</strong><p>IVA 19%, retenciones, ICA/ReteICA por municipio, autorretencion y conciliacion por tercero.</p></article>
            <article><strong>Nomina y prestadores</strong><p>Nomina electronica, seguridad social, honorarios, documento soporte y soportes de costos.</p></article>
            <article><strong>Cartera y flujo de caja</strong><p>Anticipos, saldos por evento, edades de cartera, pagos a proveedores y utilidad por proyecto.</p></article>
        </div>
    </div>

    <form class="panel form-grid accounting-form" method="post" action="<?= e($formAction) ?>">
        <h2><?= e($formTitle) ?></h2>
        <?php if ($entry !== null): ?><input type="hidden" name="id" value="<?= e($entry['id']) ?>"><?php endif; ?>
        <label>Fecha <input name="entry_date" type="date" value="<?= e($entry['entry_date'] ?? date('Y-m-d')) ?>" required></label>
        <label>Tipo
            <select name="type">
                <?php foreach (['ingreso' => 'Ingreso', 'egreso' => 'Egreso'] as $value => $label): ?><option value="<?= e($value) ?>" <?= ($entry['type'] ?? 'ingreso') === $value ? 'selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?>
            </select>
        </label>
        <label>Categoria <input name="category" value="<?= e($entry['category'] ?? '') ?>" placeholder="Factura electronica, nomina, proveedor" required></label>
        <label>Tercero <input name="third_party" value="<?= e($entry['third_party'] ?? '') ?>" required></label>
        <label>Base <input name="base_amount" type="number" min="0" step="1000" value="<?= e($entry['base_amount'] ?? '') ?>" required></label>
        <label>IVA / impuesto <input name="tax_amount" type="number" min="0" step="1000" value="<?= e($entry['tax_amount'] ?? 0) ?>"></label>
        <label>Retencion <input name="withholding_amount" type="number" min="0" step="1000" value="<?= e($entry['withholding_amount'] ?? 0) ?>"></label>
        <label>Total <input name="total" type="number" min="0" step="1000" value="<?= e($entry['total'] ?? '') ?>" required></label>
        <label>Documento <input name="document_number" value="<?= e($entry['document_number'] ?? '') ?>" placeholder="FEV-0001, DS-0001, NE-2026"></label>
        <label>Estado
            <select name="payment_status">
                <?php foreach (['pendiente' => 'Pendiente', 'pagado' => 'Pagado', 'parcial' => 'Parcial', 'vencido' => 'Vencido'] as $value => $label): ?><option value="<?= e($value) ?>" <?= ($entry['payment_status'] ?? 'pendiente') === $value ? 'selected' : '' ?>><?= e($label) ?></option><?php endforeach; ?>
            </select>
        </label>
        <label class="span-2">Descripcion <textarea name="description"><?= e($entry['description'] ?? '') ?></textarea></label>
        <button class="primary-btn"><?= e($submitLabel) ?></button>
        <?php if ($entry !== null): ?><a class="secondary-btn span-2" href="/contabilidad">Cancelar edicion</a><?php endif; ?>
    </form>
</section>
