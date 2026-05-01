<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;

final class Service extends Model
{
    protected string $table = 'services';

    protected array $fillable = [
        'name',
        'category',
        'description',
        'billing_unit',
        'price',
        'cost',
        'capacity',
        'status',
    ];
}
