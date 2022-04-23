<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class Plan extends Model {
    protected $table = 'plans';

    protected $fillable = [
        'name',
        'descricao_comercial',
        'minutos_franquia',
        'percentual_acrescimo'
    ];
}