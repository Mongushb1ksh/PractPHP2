<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Position extends Model
{
   use HasFactory;
   protected $primaryKey = 'position_id';
   public $timestamps = false;
   protected $fillable = [
    'position_name'
   ];

   public function employees()
    {
        return $this->hasMany(Employee::class, 'position_id');
    }
}

