<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Validators\EmployeeValidator;
use Src\Request;

class Employee  extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
            'last_name', 'first_name', 'middle_name',
            'birth_date', 'registration_address',
            'division_id', 'staff_category_id', 'position_id'
    ];

    public static function createEmployee(array $data): self
    {


        $validator = EmployeeValidator::validateCreate(new Request($data));
        
        if (!$validator['valid']) {
            $errorMessages = [];
            foreach ($validator['errors'] as $field => $errors) {
                $errorMessages[] = implode(', ', $errors);
            }
            throw new \InvalidArgumentException(implode('; ', $errorMessages));
        }
        
        $employee = self::create($data);

        $division = Division::find($employee->division_id);
        if ($division) {
            $division->updateDivisionStats();
        }
        return $employee;
    }
    public static function changeDivision(int $employeeId, ?int $newDivisionId): bool
    {
        if ($newDivisionId === null) {
            throw new \InvalidArgumentException('Не выбрано новое подразделение');
        }
    
        $employee = self::findOrFail($employeeId);
        $oldDivisionId = $employee->division_id;
        
        $employee->division_id = $newDivisionId;
        $result = $employee->save();
        
        if ($result) {
            Division::find($oldDivisionId)?->updateDivisionStats();
            Division::find($newDivisionId)?->updateDivisionStats();
        }
        
        return $result;
    }
    
    public static function getByCategory(?int $categoryId = null)
    {
        $query = self::with(['position', 'division']);
        
        if ($categoryId !== null) {
            $query->where('staff_category_id', $categoryId);
        }

        
        return $query->get();
    }


    public function division(){
        return $this->belongsTo(Division::class, 'division_id');
    }
    public function staffCategory(){
        return $this->belongsTo(StaffCategory::class);
    }
    public function position() {
        return $this->belongsTo(Position::class);
    }
    public function getFullNameAttribute(): string{
        return trim("{$this->last_name} {$this->first_name} {$this->middle_name}");
    }
    public function getAgeAttribute(): int{
        $birthday = new \DateTime($this->birth_date);
        $today = new \DateTime();
        return $today->diff($birthday)->y;    
    }
    public static function findByDivision(int $divisionId){
        return self::where('division_id', $divisionId)->get()->toArray();
    }
    public static function averageAgeByDivision(){
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

    public static function findByStaffCategory(int $categoryId){
        return self::where('staff_category_id', $categoryId)->get()->toArray();
    }


    public static function getAllWithDivisions()
    {
        return [
            'employees' => self::all(),
            'divisions' => Division::all()
        ];
    }
}


