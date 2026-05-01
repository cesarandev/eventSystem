<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AccountingEntry;
use App\Models\Client;
use App\Models\Event;
use App\Models\Quote;

final class DashboardController extends Controller
{
    public function index(): void
    {
        $clients = new Client();
        $quotes = new Quote();
        $events = new Event();
        $entries = new AccountingEntry();

        $this->view('dashboard/index', [
            'title' => 'Dashboard',
            'clientCount' => $clients->count(),
            'openQuotes' => $quotes->count("status IN ('borrador', 'enviada', 'negociacion')"),
            'closedDeals' => $quotes->count("status = 'aprobada'"),
            'upcomingEventsCount' => $events->count('event_date >= CURDATE()'),
            'monthlyRevenue' => $entries->sum('total', "type = 'ingreso' AND MONTH(entry_date) = MONTH(CURDATE()) AND YEAR(entry_date) = YEAR(CURDATE())"),
            'monthlyCosts' => $entries->sum('total', "type = 'egreso' AND MONTH(entry_date) = MONTH(CURDATE()) AND YEAR(entry_date) = YEAR(CURDATE())"),
            'pipeline' => $quotes->sum('total', "status IN ('borrador', 'enviada', 'negociacion')"),
            'upcomingEvents' => $events->upcoming(),
            'latestQuotes' => $quotes->withClients(),
        ]);
    }
}
