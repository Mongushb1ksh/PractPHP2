<h2>Выбор сотрудников по составу</h2>
<form method="GET" class="form-container">
    <div class="form-group">
        <label for="category_id">Категория персонала</label>
        <select id="category_id" name="category_id" required>
            <option value="">Выберите категорию</option>
            <?php foreach ($categories as $staff_category): ?>
                <option value="<?= $staff_category->staff_category_id ?>"
                    <?= ($selected_category_id ?? '') == $staff_category->staff_category_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($staff_category->staff_category_name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Показать сотрудников</button>
</form>

<?php if (!empty($employees)): ?>
    <h4>Список сотрудников</h4>
    <table>
        <thead>
            <tr>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Дата рождения</th>
                <th>Должность</th>
                <th>Подразделение</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees as $employee): ?>
                <tr>
                    <td><?= htmlspecialchars($employee->last_name) ?></td>
                    <td><?= htmlspecialchars($employee->first_name) ?></td>
                    <td><?= htmlspecialchars($employee->birth_date) ?></td>
                    <td><?= htmlspecialchars($employee->position->name) ?></td>
                    <td><?= htmlspecialchars($employee->division->division_name) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php elseif ($selected_category_id): ?>
    <p>Нет сотрудников в выбранной категории.</p>
<?php endif; ?>