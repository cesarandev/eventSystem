<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class AccountingEntry extends Model
{
    protected string $table = 'accounting_entries';

    protected array $fillable = [
        'entry_date',
        'type',
        'category',
        'third_party',
        'description',
        'base_amount',
        'tax_amount',
        'withholding_amount',
        'total',
        'document_number',
        'payment_status',
    ];
}
