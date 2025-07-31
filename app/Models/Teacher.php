<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nip', 'subject_id', 'phone', 'email'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}