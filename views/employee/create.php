<h2>Добавление сотрудника</h2>
<form method="POST">
    <input type="text" name="last_name" placeholder="Введите фамилию сотрудника" required>
    <input type="text" name="first_name" placeholder="Введите имя сотрудника" required>
    <input type="text" name="middle_name" placeholder="Введите отчество сотрудника" required>
    <label>Дата рождения</label>
    <input type="date" name="birth_date" required >
    <input type="text" name="registration_address" placeholder="Введите адрес регистрации сотрудника" required>
    <label>Подразделения</label>
    <select <?= isset($errors['division_id']) ? 'is-invalid' : '' ?>" 
            name="division_id" required>
        <option value="">Выберите подразделение</option>
        <?php foreach ($divisions as $division): ?>
            <option value="<?= $division->division_id ?>"
                <?= ($request->division_id ?? '') == $division->division_id ? 'selected' : '' ?>>
                <?= htmlspecialchars($division->division_name) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label>Должность</label>
    <select <?= isset($errors['position_id']) ? 'is-invalid' : '' ?>" 
            name="position_id" required>
        <option value="">Выберите должность</option>
        <?php  foreach ($positions as $position):  ?>
            <option value="<?= $position->position_id ?>" 
                <?= ($request->position_id  ?? '') == $position->position_id ? 'selected' : '' ?>>
                <?= htmlspecialchars($position->position_name) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <label>Категория персонала</label>
    <select <?= isset($errors['staff_category_id']) ? 'is-invalid' : '' ?>" 
            name="staff_category_id" required>
        <option value="">Выберите категорию</option>
        <?php  foreach ($categories  as $category):  ?>
            <option value="<?= $category->staff_category_id ?>" 
                <?= ($request->staff_category_id   ?? '') == $category->staff_category_id ? 'selected' : '' ?>>
                <?= htmlspecialchars($category->staff_category_name) ?>
            </option>
        <?php endforeach; ?>
    </select>
    <button type="submit">Добавить сотрудника</button>
    <a href="/dashboard">Отмена</a>



</form>