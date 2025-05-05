<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class DivisionType extends Model
{
   use HasFactory;
   protected $primaryKey = 'division_type_id';
   public $timestamps = false;
   protected $fillable = [
    'division_type_name'
   ];

   public function divisions()
    {
        return $this->hasMany(Division::class, 'division_type_id');
    }
}

