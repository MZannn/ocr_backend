<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    use HasFactory;
    protected $fillable = [
        'identity_number',
        'name',
        'address',
        'phone_number',
        'residents_id',
        'date',
        'status',
        'photo',
        'date_checkout',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function visitorHistory()
    {
        return $this->hasMany(VisitorHistory::class);
    }
    public function resident()
    {
        return $this->belongsTo(Resident::class, 'residents_id', 'id');
    }
}