<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;

class Division extends Model 
{
   use HasFactory;
   protected $primaryKey = 'division_id';
   public $timestamps = false;
   protected $fillable = [
    'division_name',
    'division_type_id',
    'employee_count',
       'average_age',
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

    public function updateAverageAge()
    {
        $averageAge = $this->employees()
            ->selectRaw('AVG(TIMESTAMPDIFF(YEAR, birth_date, CURDATE())) as average_age')
            ->value('average_age');

        $this->update([
            'average_age' => $averageAge ? round($averageAge, 1) : null
        ]);
    }

    public function updateDivisionStats()
    {
        $this->updateEmployeeCount();
        $this->updateAverageAge();
    }

}

