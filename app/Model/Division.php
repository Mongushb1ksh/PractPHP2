<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Validators\DivisionValidator;
use Src\Request;


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

   public static function createDivision(array $data): bool
    {
        $validator = DivisionValidator::validateCreate(new Request($data));
        
        if (!$validator['valid']) {
            throw new \InvalidArgumentException($validator['errors']);
        }
        
        return (bool) self::create($data);
    }
    
    public static function getWithDetails(int $id): ?self
    {
        return self::with([
            'type',
            'employees' => function($query) {
                $query->with(['position', 'staffCategory']);
            }
        ])->find($id);
    }

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

