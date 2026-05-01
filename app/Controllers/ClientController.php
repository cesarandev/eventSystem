<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Client;

final class ClientController extends Controller
{
    public function index(): void
    {
        $this->view('clients/index', [
            'title' => 'Clientes',
            'clients' => (new Client())->all('name ASC'),
            'client' => null,
            'formAction' => '/clientes',
            'formTitle' => 'Crear cliente',
            'submitLabel' => 'Guardar cliente',
        ]);
    }

    public function edit(): void
    {
        $model = new Client();
        $client = $model->find((int) ($_GET['id'] ?? 0));

        if ($client === null) {
            $this->flash('Cliente no encontrado.');
            $this->redirect('/clientes');
        }

        $this->view('clients/index', [
            'title' => 'Editar cliente',
            'clients' => $model->all('name ASC'),
            'client' => $client,
            'formAction' => '/clientes/actualizar',
            'formTitle' => 'Editar cliente',
            'submitLabel' => 'Actualizar cliente',
        ]);
    }

    public function store(): void
    {
        (new Client())->create($this->payload());

        $this->flash('Cliente creado correctamente.');
        $this->redirect('/clientes');
    }

    public function update(): void
    {
        (new Client())->update((int) ($_POST['id'] ?? 0), $this->payload());

        $this->flash('Cliente actualizado correctamente.');
        $this->redirect('/clientes');
    }

    private function payload(): array
    {
        return [
            'name' => trim($_POST['name'] ?? ''),
            'document_type' => $_POST['document_type'] ?? 'NIT',
            'document_number' => trim($_POST['document_number'] ?? ''),
            'contact_name' => trim($_POST['contact_name'] ?? ''),
            'phone' => trim($_POST['phone'] ?? ''),
            'email' => trim($_POST['email'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'address' => trim($_POST['address'] ?? ''),
            'segment' => $_POST['segment'] ?? 'Empresa',
            'status' => $_POST['status'] ?? 'prospecto',
            'notes' => trim($_POST['notes'] ?? ''),
        ];
    }
}
