<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Supplier extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'address'];

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

