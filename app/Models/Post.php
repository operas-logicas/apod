<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin Builder
 */
class Post extends Model
{
    protected $fillable = [
        'date', 'img_url', 'title', 'copyright', 'original_date', 'explanation', 'active'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    /**
     * Mutators
     */
    public function setDateAttribute($value) {
        $this->attributes['date'] = date('Y-m-d', strtotime($value));
    }

    public function setOriginalDateAttribute($value) {
        $this->attributes['original_date'] = date('Y-m-d', strtotime($value));
    }

    /**
     * Accessors
     */
    public function getDateAttribute($value) {
        return date('F j, Y', strtotime($value));
    }

    public function getOriginalDateAttribute($value) {
        return date('F j, Y', strtotime($value));
    }
}
