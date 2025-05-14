<?php

namespace Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Src\Auth\IdentityInterface;
use Src\Request;
use Src\Auth\Auth;
use Validators\UserValidator;

class User extends Model implements IdentityInterface
{
   use HasFactory;
   protected $primaryKey = 'id';

   public $timestamps = false;
   protected $fillable = [
       'name',
       'lastName',
       'login',
       'password',
       'role',
       
   ];

   public static function getAllByRole(string $role)
    {
        return self::where('role', $role)->get();
    }

    public static function createHr(array $data): bool
    {
        $result = UserValidator::validateCreate(new Request($data));
        
        if (!$result['valid']) {
            return false;
        }

        return (bool) self::create($data);
    }

    public static function getAuthenticatedUser()
    {
        return Auth::user();
    }

   protected static function booted()
   {
       static::created(function ($user) {
           $user->password = md5($user->password);
           $user->save();
       });
   }

   //Выборка пользователя по первичному ключу
   public function findIdentity(int $id)
   {
       return self::where('id', $id)->first();
   }

   //Возврат первичного ключа
   public function getId(): int
   {
       return $this->id;
   }

   //Возврат аутентифицированного пользователя
   public function attemptIdentity(array $credentials)
   {
       return self::where(['login' => $credentials['login'],
           'password' => md5($credentials['password'])])->first();
   }
}

