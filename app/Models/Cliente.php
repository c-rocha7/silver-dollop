<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Cliente extends Model
{
    use HasApiTokens, HasFactory;

    protected $primaryKey = 'codigo';

    public $incrementing = false;

    protected $keyType = 'decimal';

    protected $fillable = [
        'empresa',
        'codigo',
        'razao_social',
        'tipo',
        'cpf_cnpj',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class, 'empresa', 'codigo');
    }
}
