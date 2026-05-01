<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Client;
use App\Models\Quote;

final class QuoteController extends Controller
{
    public function index(): void
    {
        $this->view('quotes/index', [
            'title' => 'Cotizaciones',
            'quotes' => (new Quote())->withClients(),
            'clients' => (new Client())->all('name ASC'),
        ]);
    }

    public function store(): void
    {
        $subtotal = (float) ($_POST['subtotal'] ?? 0);
        $tax = round($subtotal * 0.19, 2);
        $discount = (float) ($_POST['discount'] ?? 0);

        (new Quote())->create([
            'client_id' => (int) ($_POST['client_id'] ?? 0),
            'code' => trim($_POST['code'] ?? ('COT-' . date('YmdHis'))),
            'event_name' => trim($_POST['event_name'] ?? ''),
            'event_date' => $_POST['event_date'] ?? null,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'total' => max(0, $subtotal + $tax - $discount),
            'status' => $_POST['status'] ?? 'borrador',
            'probability' => (int) ($_POST['probability'] ?? 50),
            'valid_until' => $_POST['valid_until'] ?? null,
            'notes' => trim($_POST['notes'] ?? ''),
        ]);

        $this->flash('Cotizacion creada correctamente.');
        $this->redirect('/cotizaciones');
    }
}
