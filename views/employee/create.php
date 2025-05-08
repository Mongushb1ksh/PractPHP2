<h2>Добавление сотрудника</h2>
<h3><?= $message ?? ''; ?></h3>

<form method="POST" class="form-container">
<input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <div class="form-group">
        <label for="last_name">Фамилия</label>
        <input type="text" id="last_name" name="last_name" placeholder="Введите фамилию сотрудника" >
    </div>
    <div class="form-group">
        <label for="first_name">Имя</label>
        <input type="text" id="first_name" name="first_name" placeholder="Введите имя сотрудника" >
    </div>
    <div class="form-group">
        <label for="middle_name">Отчество</label>
        <input type="text" id="middle_name" name="middle_name" placeholder="Введите отчество сотрудника" >
    </div>
    <div class="form-group">
        <label for="birth_date">Дата рождения</label>
        <input type="date" id="birth_date" name="birth_date" >
    </div>
    <div class="form-group">
        <label for="registration_address">Адрес регистрации</label>
        <input type="text" id="registration_address" name="registration_address" placeholder="Введите адрес регистрации сотрудника" >
    </div>
    <div class="form-group">
        <label for="division_id">Подразделение</label>
        <select id="division_id" name="division_id" <?= isset($errors['division_id']) ? 'is-invalid' : '' ?>" >
            <option value="">Выберите подразделение</option>
            <?php foreach ($divisions as $division): ?>
                <option value="<?= $division->division_id ?>"
                    <?= ($request->division_id ?? '') == $division->division_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($division->division_name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="position_id">Должность</label>
        <select id="position_id" name="position_id" <?= isset($errors['position_id']) ? 'is-invalid' : '' ?>" >
            <option value="">Выберите должность</option>
            <?php foreach ($positions as $position): ?>
                <option value="<?= $position->position_id ?>"
                    <?= ($request->position_id ?? '') == $position->position_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($position->position_name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="staff_category_id">Категория персонала</label>
        <select id="staff_category_id" name="staff_category_id" <?= isset($errors['staff_category_id']) ? 'is-invalid' : '' ?>" >
            <option value="">Выберите категорию</option>
            <?php foreach ($categories as $category): ?>
                <option value="<?= $category->staff_category_id ?>"
                    <?= ($request->staff_category_id ?? '') == $category->staff_category_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($category->staff_category_name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Добавить сотрудника</button>
        <a href="<?= app()->route->getUrl('/dashboard') ?>" class="btn btn-link">Отмена</a>
    </div>
</form>

<style>
    .form-container {
    max-width: 600px;
    margin: 30px auto;
    padding: 25px;
    background: white;
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
}

.form-container h2 {
    color: #2c3e50;
    margin-bottom: 20px;
    text-align: center;
}

.form-group {
    margin-bottom: 15px;
}

.form-group label {
    display: block;
    margin-bottom: 5px;
    font-weight: 500;
    color: #333;
}

.form-group input,
.form-group select {
    width: 90%;
    padding: 10px 15px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1em;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #3498db;
    outline: none;
    box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
}

.form-group input::placeholder {
    color: #aaa;
}

.form-group select {
    appearance: none;
    background: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' width='16' height='16'%3E%3Cpath fill='%23333' d='M7 10l5 5 5-5z'/%3E%3C/svg%3E") no-repeat right 10px center / 16px;
}

.form-actions {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 20px;
}

.btn {
    display: inline-block;
    padding: 10px 20px;
    border-radius: 4px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
}

.btn-primary {
    background-color: #3498db;
    color: white;
    border: none;
}

.btn-primary:hover {
    background-color: #2980b9;
    transform: translateY(-2px);
}

.btn-link {
    color: #3498db;
    padding: 5px 10px;
    border-radius: 4px;
}

.btn-link:hover {
    background-color: #e1f0fa;
}

/* Стили ошибок */
.is-invalid {
    border-color: #e74c3c !important;
}

.invalid-feedback {
    color: #e74c3c;
    font-size: 0.9em;
    margin-top: 5px;
    display: block;
}

/* Адаптивность */
@media (max-width: 768px) {
    .form-container {
        padding: 15px;
    }

    .form-group input,
    .form-group select {
        font-size: 0.9em;
    }

    .btn {
        font-size: 0.9em;
    }
}
</style>