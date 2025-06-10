<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany; // Importe a classe HasMany

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // Adiciona a coluna 'role' para definir o tipo de usuário
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Define a relação de que um usuário pode ter muitas tarefas.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Define a relação de que um usuário (cliente) pode ter muitos projetos.
     */
    public function projetos(): HasMany
    {
        return $this->hasMany(Projeto::class, 'client_id');
    }
}