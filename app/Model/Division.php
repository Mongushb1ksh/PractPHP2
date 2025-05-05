<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Division extends Model 
{
   use HasFactory;

   public $timestamps = false;
   protected $fillable = [
    'division_name',
    'division_type_id',
    'employee_count'
   ];

   public function type()
    {
        return $this->belongsTo(DivisionType::class, 'division_type_id');
    }

    public function employees()
    {
        return $this->hasMany(Employee::class, 'division_id');
    }
    public function updateEmployeeCount()
    {
        $this->update([
            'employee_count' => $this->employees()->count()
        ]);
    }

}

