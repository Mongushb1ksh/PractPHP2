<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee  extends Model
{
   use HasFactory;
   protected $primaryKey = 'employee_id';
   public $timestamps = false;

   protected $fillable = [
        'last_name', 'first_name', 'middle_name',
        'birth_date', 'registration_address',
        'division_id', 'staff_category_id', 'position_id'
   ];

   public function division()
   {
       return $this->belongsTo(Division::class, 'division_id');
   }
   public function staffCategory()
    {
        return $this->belongsTo(StaffCategory::class, 'staff_category_id');
    }
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
    
    // Полное имя сотрудника
    public function getFullNameAttribute(): string
    {
        return trim("{$this->last_name} {$this->first_name} {$this->middle_name}");
    }
    
    public function getAgeAttribute(): int
    {
        $birthday = new \DateTime($this->birth_date);
        $today = new \DateTime();
        return $today->diff($birthday)->y;    
    }

    // Методы запросов
    public static function findByDivision(int $divisionId)
    {
        return self::where('division_id', $divisionId)->get()->toArray();
    }

    public static function averageAgeByDivision()
    {
        return self::selectRaw('
                divisions.division_id,
                divisions.division_name,
                AVG(YEAR(CURRENT_DATE) - YEAR(employees.birth_date)) as avg_age,
                COUNT(employees.id) as employee_count
            ')
            ->join('divisions', 'employees.division_id', '=', 'divisions.division_id')
            ->groupBy('divisions.division_id', 'divisions.division_name')
            ->get()
            ->toArray();
    }

    public static function findByStaffCategory(int $categoryId)
    {
        return self::where('staff_category_id', $categoryId)->get()->toArray();
    }

}


