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
        ]);
    }

    public function store(): void
    {
        (new Client())->create([
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
        ]);

        $this->flash('Cliente creado correctamente.');
        $this->redirect('/clientes');
    }
}
