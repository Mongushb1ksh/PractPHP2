<h2>Добавление нового подразделения</h2>
<h3><?= $message ?? ''; ?></h3>
<form method="POST" class="form-container">
<input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <div class="form-group">
        <input type="text" name="division_name" placeholder="Введите название подразделения" >
    </div>
    <div class="form-group">
        <label for="division_type_id">Тип подразделения</label>
        <select id="division_type_id" name="division_type_id" <?= isset($errors['division_type_id']) ? 'is-invalid' : '' ?>" >
            <option value="">Выберите тип подразделение</option>
            <?php foreach ($division_types as $division_type): ?>
                <option value="<?= $division_type->division_type_id ?>"
                    <?= ($request->division_type_id ?? '') == $division_type->division_type_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($division_type->division_type_name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Создать подразделение</button>
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
    width: 100%;
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