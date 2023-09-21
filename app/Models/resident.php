<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class resident extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'identity_number',
        'name',
        'address',
        'phone_number',
    ];
    protected $hidden = [

        'created_at',
        'updated_at',
    ];
    public function visitorHistory()
    {
        return $this->hasMany(VisitorHistory::class);
    }
    public function visitors()
    {
        return $this->hasMany(Visitor::class, 'residents_id', 'id');
    }
}