<h2>Авторизация</h2>
<pre><?= $message ?? ''; ?></pre>

<h3><?= app()->auth->user()->name ?? ''; ?></h3>
<?php
if (!app()->auth::check()):
   ?>
   <form method="post">
   <input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
       <label><input type="text" name="login" placeholder="Введите логин"></label>
       <label><input type="password" name="password" placeholder="Введите пароль"></label>
       <button>Войти</button>
   </form>
<?php endif; ?>


<style>
    form{
        margin-top: 4%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 10px;
        background: #84C7EE;
        width: 100%;
        max-width: 830px;
        height: 200px;
        border-radius: 30px;
        
    }
    label{
        width: 80%;
        max-width: 650px;
    }

    button{
        border-radius: 30px;
        width: 80%;
        border: #838383 solid 1px;
        height: 40px;
        max-width: 650px;
        background: #50A2D1;
        color: white;
        border: none;
    }

    input{
        border-radius: 30px;
        width: 92%;
        border: #838383 solid 1px;
        height: 40px;
        padding: 0 4%;
        max-width: 650px;
        background: white;

    }
    h2{
        margin-top: 5%;
    }
</style>