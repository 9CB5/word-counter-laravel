<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Website extends Model
{
    use HasFactory;

    protected $fillable = ["url", "total_word_count"];

    public function keywords() {
        return $this->belongsToMany(Keyword::class)->withPivot('frequency', 'density');
    }

    public function phrases() {
        return $this->belongsToMany(Phrase::class)->withPivot('frequency', 'density');
    }
}
