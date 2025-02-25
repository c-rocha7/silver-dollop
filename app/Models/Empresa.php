<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Empresa extends Model
{
    use HasApiTokens;
    use HasFactory;

    protected $primaryKey = 'codigo';

    public $incrementing = false;

    protected $keyType = 'decimal';

    protected $fillable = [
        'codigo',
        'empresa',
        'sigla',
        'razao_social',
    ];

    public function clientes()
    {
        return $this->hasMany(Cliente::class, 'empresa', 'codigo');
    }
}
