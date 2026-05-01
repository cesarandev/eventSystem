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
            'quote' => null,
            'formAction' => '/cotizaciones',
            'formTitle' => 'Crear cotizacion',
            'submitLabel' => 'Guardar cotizacion',
        ]);
    }

    public function edit(): void
    {
        $model = new Quote();
        $quote = $model->find((int) ($_GET['id'] ?? 0));

        if ($quote === null) {
            $this->flash('Cotizacion no encontrada.');
            $this->redirect('/cotizaciones');
        }

        $this->view('quotes/index', [
            'title' => 'Editar cotizacion',
            'quotes' => $model->withClients(),
            'clients' => (new Client())->all('name ASC'),
            'quote' => $quote,
            'formAction' => '/cotizaciones/actualizar',
            'formTitle' => 'Editar cotizacion',
            'submitLabel' => 'Actualizar cotizacion',
        ]);
    }

    public function store(): void
    {
        (new Quote())->create($this->payload());

        $this->flash('Cotizacion creada correctamente.');
        $this->redirect('/cotizaciones');
    }

    public function update(): void
    {
        (new Quote())->update((int) ($_POST['id'] ?? 0), $this->payload());

        $this->flash('Cotizacion actualizada correctamente.');
        $this->redirect('/cotizaciones');
    }

    private function payload(): array
    {
        $subtotal = (float) ($_POST['subtotal'] ?? 0);
        $tax = round($subtotal * 0.19, 2);
        $discount = (float) ($_POST['discount'] ?? 0);

        return [
            'client_id' => (int) ($_POST['client_id'] ?? 0),
            'code' => trim($_POST['code'] ?? ('COT-' . date('YmdHis'))),
            'event_name' => trim($_POST['event_name'] ?? ''),
            'event_date' => ($_POST['event_date'] ?? '') !== '' ? $_POST['event_date'] : null,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'total' => max(0, $subtotal + $tax - $discount),
            'status' => $_POST['status'] ?? 'borrador',
            'probability' => (int) ($_POST['probability'] ?? 50),
            'valid_until' => ($_POST['valid_until'] ?? '') !== '' ? $_POST['valid_until'] : null,
            'notes' => trim($_POST['notes'] ?? ''),
        ];
    }
}
