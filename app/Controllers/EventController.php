<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Client;
use App\Models\Event;
use App\Models\Quote;

final class EventController extends Controller
{
    public function index(): void
    {
        $this->view('events/index', [
            'title' => 'Eventos',
            'events' => (new Event())->withRelations(),
            'clients' => (new Client())->all('name ASC'),
            'quotes' => (new Quote())->withClients(),
            'event' => null,
            'formAction' => '/eventos',
            'formTitle' => 'Programar evento',
            'submitLabel' => 'Crear evento',
        ]);
    }

    public function edit(): void
    {
        $model = new Event();
        $event = $model->find((int) ($_GET['id'] ?? 0));

        if ($event === null) {
            $this->flash('Evento no encontrado.');
            $this->redirect('/eventos');
        }

        $this->view('events/index', [
            'title' => 'Editar evento',
            'events' => $model->withRelations(),
            'clients' => (new Client())->all('name ASC'),
            'quotes' => (new Quote())->withClients(),
            'event' => $event,
            'formAction' => '/eventos/actualizar',
            'formTitle' => 'Editar evento',
            'submitLabel' => 'Actualizar evento',
        ]);
    }

    public function store(): void
    {
        (new Event())->create($this->payload());

        $this->flash('Evento programado correctamente.');
        $this->redirect('/eventos');
    }

    public function update(): void
    {
        (new Event())->update((int) ($_POST['id'] ?? 0), $this->payload());

        $this->flash('Evento actualizado correctamente.');
        $this->redirect('/eventos');
    }

    private function payload(): array
    {
        return [
            'client_id' => (int) ($_POST['client_id'] ?? 0),
            'quote_id' => ($_POST['quote_id'] ?? '') !== '' ? (int) $_POST['quote_id'] : null,
            'name' => trim($_POST['name'] ?? ''),
            'event_date' => $_POST['event_date'] ?? null,
            'start_time' => ($_POST['start_time'] ?? '') !== '' ? $_POST['start_time'] : null,
            'end_time' => ($_POST['end_time'] ?? '') !== '' ? $_POST['end_time'] : null,
            'venue' => trim($_POST['venue'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'team_notes' => trim($_POST['team_notes'] ?? ''),
            'logistics_notes' => trim($_POST['logistics_notes'] ?? ''),
            'status' => $_POST['status'] ?? 'programado',
            'expected_margin' => (float) ($_POST['expected_margin'] ?? 0),
        ];
    }
}
