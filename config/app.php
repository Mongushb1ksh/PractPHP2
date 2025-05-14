<?php
return [
   //Класс аутентификации
   'auth' => \Src\Auth\Auth::class,
   //Клас пользователя
   'identity' => \Model\User::class,
   //Классы для middleware
   'routeMiddleware' => [
        'auth' => \Middlewares\AuthMiddleware::class,
   ],
   'routeAppMiddleware' => [
     'trim' => \Middlewares\TrimMiddleware::class,
   ],
   'routeAppMiddleware' => [
     'trim' => \Middlewares\TrimMiddleware::class,
     'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
   ],
   'routeAppMiddleware' => [
      'csrf' => \Middlewares\CSRFMiddleware::class,
      'trim' => \Middlewares\TrimMiddleware::class,
      'specialChars' => \Middlewares\SpecialCharsMiddleware::class,
   ],
  
  
  

];
