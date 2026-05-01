<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class Event extends Model
{
    protected string $table = 'events';

    protected array $fillable = [
        'client_id',
        'quote_id',
        'name',
        'event_date',
        'start_time',
        'end_time',
        'venue',
        'city',
        'team_notes',
        'logistics_notes',
        'status',
        'expected_margin',
    ];

    public function upcoming(): array
    {
        $statement = $this->db()->query(
            'SELECT events.*, clients.name AS client_name, quotes.code AS quote_code
             FROM events
             INNER JOIN clients ON clients.id = events.client_id
             LEFT JOIN quotes ON quotes.id = events.quote_id
             WHERE events.event_date >= CURDATE()
             ORDER BY events.event_date ASC, events.start_time ASC'
        );

        return $statement->fetchAll();
    }
}
