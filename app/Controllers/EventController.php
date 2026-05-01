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
            'events' => (new Event())->upcoming(),
            'clients' => (new Client())->all('name ASC'),
            'quotes' => (new Quote())->withClients(),
        ]);
    }

    public function store(): void
    {
        (new Event())->create([
            'client_id' => (int) ($_POST['client_id'] ?? 0),
            'quote_id' => ($_POST['quote_id'] ?? '') !== '' ? (int) $_POST['quote_id'] : null,
            'name' => trim($_POST['name'] ?? ''),
            'event_date' => $_POST['event_date'] ?? null,
            'start_time' => $_POST['start_time'] ?? null,
            'end_time' => $_POST['end_time'] ?? null,
            'venue' => trim($_POST['venue'] ?? ''),
            'city' => trim($_POST['city'] ?? ''),
            'team_notes' => trim($_POST['team_notes'] ?? ''),
            'logistics_notes' => trim($_POST['logistics_notes'] ?? ''),
            'status' => $_POST['status'] ?? 'programado',
            'expected_margin' => (float) ($_POST['expected_margin'] ?? 0),
        ]);

        $this->flash('Evento programado correctamente.');
        $this->redirect('/eventos');
    }
}
