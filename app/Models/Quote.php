<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class Quote extends Model
{
    protected string $table = 'quotes';

    protected array $fillable = [
        'client_id',
        'code',
        'event_name',
        'event_date',
        'subtotal',
        'tax',
        'discount',
        'total',
        'status',
        'probability',
        'valid_until',
        'notes',
    ];

    public function withClients(): array
    {
        $statement = $this->db()->query(
            'SELECT quotes.*, clients.name AS client_name
             FROM quotes
             INNER JOIN clients ON clients.id = quotes.client_id
             ORDER BY quotes.created_at DESC'
        );

        return $statement->fetchAll();
    }
}
