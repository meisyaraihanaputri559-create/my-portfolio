<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    // Mengizinkan seluruh kolom diisi melalui form (Mass Assignment)
    protected $guarded = ['id'];
}
