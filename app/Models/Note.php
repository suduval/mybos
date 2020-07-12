<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';

    protected $fillable = ['author', 'note'];

    public function scopeSearch($query, $params){
        if(isset($params['search'])){
            return $query->where('note', 'like', '%'. $params['search'] .'%');
        }
        return $query;
    }

}
