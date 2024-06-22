<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class product extends Authenticatable
{
  use HasFactory;

  protected $table = 'product';

  protected $fillable = ['id', 'name', 'price', 'detail', 'publish'];

  public $timestamps = false;

  /*public function staff()
  {
    return $this->belongsTo(Staff::class, 'staffid');
  }*/
}
