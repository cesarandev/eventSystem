<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Service;

final class ServiceController extends Controller
{
    public function index(): void
    {
        $this->view('services/index', [
            'title' => 'Servicios',
            'services' => (new Service())->all('category ASC, name ASC'),
        ]);
    }

    public function store(): void
    {
        (new Service())->create([
            'name' => trim($_POST['name'] ?? ''),
            'category' => trim($_POST['category'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'billing_unit' => $_POST['billing_unit'] ?? 'evento',
            'price' => (float) ($_POST['price'] ?? 0),
            'cost' => (float) ($_POST['cost'] ?? 0),
            'capacity' => (int) ($_POST['capacity'] ?? 1),
            'status' => $_POST['status'] ?? 'disponible',
        ]);

        $this->flash('Servicio creado correctamente.');
        $this->redirect('/servicios');
    }
}
