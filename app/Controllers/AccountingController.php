<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\AccountingEntry;

final class AccountingController extends Controller
{
    public function index(): void
    {
        $entries = new AccountingEntry();

        $this->view('accounting/index', [
            'title' => 'Contabilidad',
            'entries' => $entries->all('entry_date DESC'),
            'income' => $entries->sum('total', "type = 'ingreso'"),
            'expenses' => $entries->sum('total', "type = 'egreso'"),
            'taxes' => $entries->sum('tax_amount'),
            'withholdings' => $entries->sum('withholding_amount'),
        ]);
    }

    public function store(): void
    {
        (new AccountingEntry())->create([
            'entry_date' => $_POST['entry_date'] ?? date('Y-m-d'),
            'type' => $_POST['type'] ?? 'ingreso',
            'category' => trim($_POST['category'] ?? ''),
            'third_party' => trim($_POST['third_party'] ?? ''),
            'description' => trim($_POST['description'] ?? ''),
            'base_amount' => (float) ($_POST['base_amount'] ?? 0),
            'tax_amount' => (float) ($_POST['tax_amount'] ?? 0),
            'withholding_amount' => (float) ($_POST['withholding_amount'] ?? 0),
            'total' => (float) ($_POST['total'] ?? 0),
            'document_number' => trim($_POST['document_number'] ?? ''),
            'payment_status' => $_POST['payment_status'] ?? 'pendiente',
        ]);

        $this->flash('Movimiento contable registrado correctamente.');
        $this->redirect('/contabilidad');
    }
}
