<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
  use HasFactory;

  protected $fillable = ['especialidad'];

  public function especialistas()
  {
    return $this->hasMany(Especialista::class);
  }
}
