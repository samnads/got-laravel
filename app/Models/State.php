<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\District;
use Illuminate\Database\Eloquent\SoftDeletes;

class State extends Model
{
    use HasFactory, SoftDeletes;
    protected $primaryKey = 'state_id';
    public function districts()
    {
        return $this->hasMany(District::class, 'state_id');
    }
}
