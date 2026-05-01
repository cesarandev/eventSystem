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
                    <thead><tr><th>Fecha</th><th>Tipo</th><th>Tercero</th><th>Documento</th><th>Total</th><th>Estado</th></tr></thead>
                    <tbody>
                    <?php foreach ($entries as $entry): ?>
                        <tr>
                            <td><?= e($entry['entry_date']) ?></td>
                            <td><?= e($entry['type']) ?><small><?= e($entry['category']) ?></small></td>
                            <td><?= e($entry['third_party']) ?><small><?= e($entry['description']) ?></small></td>
                            <td><?= e($entry['document_number']) ?></td>
                            <td><?= money($entry['total']) ?></td>
                            <td><span class="status"><?= e($entry['payment_status']) ?></span></td>
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

    <form class="panel form-grid accounting-form" method="post" action="/contabilidad">
        <h2>Registrar movimiento</h2>
        <label>Fecha <input name="entry_date" type="date" value="<?= e(date('Y-m-d')) ?>" required></label>
        <label>Tipo
            <select name="type"><option value="ingreso">Ingreso</option><option value="egreso">Egreso</option></select>
        </label>
        <label>Categoria <input name="category" placeholder="Factura electronica, nomina, proveedor" required></label>
        <label>Tercero <input name="third_party" required></label>
        <label>Base <input name="base_amount" type="number" min="0" step="1000" required></label>
        <label>IVA / impuesto <input name="tax_amount" type="number" min="0" step="1000" value="0"></label>
        <label>Retencion <input name="withholding_amount" type="number" min="0" step="1000" value="0"></label>
        <label>Total <input name="total" type="number" min="0" step="1000" required></label>
        <label>Documento <input name="document_number" placeholder="FEV-0001, DS-0001, NE-2026"></label>
        <label>Estado
            <select name="payment_status"><option value="pendiente">Pendiente</option><option value="pagado">Pagado</option><option value="parcial">Parcial</option><option value="vencido">Vencido</option></select>
        </label>
        <label class="span-2">Descripcion <textarea name="description"></textarea></label>
        <button class="primary-btn">Guardar movimiento</button>
    </form>
</section>
