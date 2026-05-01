<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class Client extends Model
{
    protected string $table = 'clients';

    protected array $fillable = [
        'name',
        'document_type',
        'document_number',
        'contact_name',
        'phone',
        'email',
        'city',
        'address',
        'segment',
        'status',
        'notes',
    ];
}
