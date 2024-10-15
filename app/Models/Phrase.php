<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phrase extends Model
{
    use HasFactory;

    protected $fillable = ["phrase"];

    public function websites() {
        return $this->belongsToMany(Website::class)->withPivot('frequency', 'density');
    }
}
