<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Fornecedor extends Model
{
    use HasFactory;

    public $incrementing = false;

    protected $table = 'fornecedores';

    protected $fillable = [
        'tipo_documento',
        'documento',
        'nome_fantasia',
        'razao_social',
        'email',
        'telefone',
        'endereco',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function setDocumentoAttribute($value)
    {
        $this->attributes['documento'] = preg_replace('/\D/', '', $value);
    }
}
