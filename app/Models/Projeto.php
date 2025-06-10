<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Projeto extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'client_id',
        'estimated_hours',
        'total_cost',
        'final_price',
    ];

    // Define a relação: um Projeto pertence a um User (cliente)
    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'client_id');
    }
}