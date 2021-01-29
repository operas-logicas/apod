<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function getDateAttribute($value) {
        return date('F j, Y', strtotime($value));
    }

    public function setDateAttribute($value) {
        $this->attributes['date'] = date('Y-d-m', strtotime($value));
    }
}
