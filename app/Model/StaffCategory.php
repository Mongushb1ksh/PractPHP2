<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class StaffCategory extends Model
{
   use HasFactory;
   protected $primaryKey = 'staff_category_id';
   public $timestamps = false;
   protected $fillable = [
    'staff_category_name'
   ];

   public function employees()
    {
        return $this->hasMany(Employee::class, 'staff_category_id');
    }
}

