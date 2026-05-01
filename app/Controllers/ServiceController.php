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
            'service' => null,
            'formAction' => '/servicios',
            'formTitle' => 'Crear servicio',
            'submitLabel' => 'Guardar servicio',
        ]);
    }

    public function edit(): void
    {
        $model = new Service();
        $service = $model->find((int) ($_GET['id'] ?? 0));

        if ($service === null) {
            $this->flash('Servicio no encontrado.');
            $this->redirect('/servicios');
        }

        $this->view('services/index', [
            'title' => 'Editar servicio',
            'services' => $model->all('category ASC, name ASC'),
            'service' => $service,
            'formAction' => '/servicios/actualizar',
            'formTitle' => 'Editar servicio',
            'submitLabel' => 'Actualizar servicio',
        ]);
    }

    public function store(): void
    {
        (new Service())->create($this->payload());

        $this->flash('Servicio creado correctamente.');
        $this->redirect('/servicios');
    }

    public function update(): void
    {
        (new Service())->update((int) ($_POST['id'] ?? 0), $this->payload());

        $this->flash('Servicio actualizado correctamente.');
        $this->redirect('/servicios');
    }

    private function payload(): array
    {
        return [
            'name' => trim($_POST['name'] ?? ''),
            'category' => trim($_POST['category'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'billing_unit' => $_POST['billing_unit'] ?? 'evento',
            'price' => (float) ($_POST['price'] ?? 0),
            'cost' => (float) ($_POST['cost'] ?? 0),
            'capacity' => (int) ($_POST['capacity'] ?? 1),
            'status' => $_POST['status'] ?? 'disponible',
        ];
    }
}
