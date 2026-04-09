<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cliente extends Model
{
    use SoftDeletes;

    protected $table = 'clientes';

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'empresa',
        'direccion',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'cliente_id');
    }
}
