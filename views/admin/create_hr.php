<h2>Добавить сотрудника отдела кадров</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Имя" required><br>
        <input type="text" name="lastName" placeholder="Фамилия" required><br>
        <input type="text" id="login" name="login" placeholder="login" required><br>
        <input type="password" id="password" name="password" placeholder="password" required><br>
        <button type="submit">Создать</button>
    </form>


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
        height: 400px;
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