<div class="container">
    <h2>Подробности подразделения: <?= htmlspecialchars($division->division_name) ?></h2>
    
    <div class="card mt-4">
        <div class="card-header">
            <h4>Основная информация</h4>
        </div>
        <div class="card-body">
            <table class="table">
                <tr>
                    <th>ID:</th>
                    <td><?= $division->division_id ?></td>
                </tr>
                <tr>
                    <th>Название:</th>
                    <td><?= htmlspecialchars($division->division_name) ?></td>
                </tr>
                <tr>
                    <th>Количество сотрудников:</th>
                    <td><?= $division->employee_count ?></td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="card mt-4">
        <div class="card-header">
            <h4>Сотрудники подразделения</h4>
        </div>
        <div class="card-body">
            <?php if ($employees->count() > 0): ?>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ФИО</th>
                            <th>Должность</th>
                            <th>Состав</th>
                            <th>Вид подразделения</th>
                            <th>Адрес регистрации</th>
                            <th>Дата рождения</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($employees as $employee): ?>
                        <tr>
                            <td>
                                <?= htmlspecialchars($employee->last_name) ?>
                                <?= htmlspecialchars($employee->first_name) ?>
                                <?= htmlspecialchars($employee->middle_name) ?>
                            </td>
                            <td><?= htmlspecialchars($employee->position->position_name ?? '') ?></td>
                            <td><?= htmlspecialchars($employee->staffCategory->staff_category_name ?? '—') ?></td>
                            <td><?= htmlspecialchars($division->type->division_type_name ?? 'Не указан') ?></td>
                            <td><?= htmlspecialchars($employee->registration_address ?? '') ?></td>
                            <td><?= $employee->birth_date ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info">В этом подразделении пока нет сотрудников</div>
            <?php endif; ?>
        </div>
    </div>

    <a href="<?= app()->route->getUrl('/dashboard') ?>" class="btn btn-primary mt-3">Назад к списку</a>
</div>

<style>
    /* Основные стили контейнера */
.container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* Заголовок страницы */
h2 {
    color: #2c3e50;
    font-weight: 600;
    margin-bottom: 25px;
    padding-bottom: 10px;
    border-bottom: 1px solid #ecf0f1;
}

/* Стили карточек */
.card {
    border: none;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
    margin-bottom: 25px;
    overflow: hidden;
}

.card-header {
    background-color: #3498db;
    color: white;
    padding: 15px 20px;
    border-bottom: none;
}

.card-header h4 {
    margin: 0;
    font-weight: 500;
}

.card-body {
    padding: 20px;
}

/* Стили таблицы */
.table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    font-size: 14px;
}

.table thead th {
    background-color: #f8f9fa;
    color: #2c3e50;
    font-weight: 600;
    padding: 12px 15px;
    border-bottom: 2px solid #dee2e6;
    vertical-align: middle;
}

.table tbody tr {
    transition: background-color 0.15s ease;
}

.table tbody tr:hover {
    background-color: #f8f9fa;
}

.table td {
    padding: 12px 15px;
    border-bottom: 1px solid #e9ecef;
    vertical-align: middle;
}

/* Стили для пола */
.table td:nth-child(3) {
    text-align: center;
    font-weight: bold;
    color: #3498db;
}

/* Стили для кнопок действий */
.action-buttons {
    display: flex;
    gap: 8px;
}

.btn-action {
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 12px;
    border: none;
    cursor: pointer;
    transition: all 0.2s;
    display: inline-flex;
    align-items: center;
    justify-content: center;
}

.btn-view {
    background-color: #3498db;
    color: white;
}

.btn-edit {
    background-color: #f39c12;
    color: white;
}

.btn-delete {
    background-color: #e74c3c;
    color: white;
}

.btn-action:hover {
    opacity: 0.9;
    transform: translateY(-1px);
}

/* Стили для пустой таблицы */
.alert-info {
    background-color: #d1ecf1;
    color: #0c5460;
    border-radius: 4px;
    padding: 15px;
    margin-bottom: 0;
}

/* Кнопка "Назад" */
.btn-primary {
    background-color: #3498db;
    border: none;
    padding: 8px 20px;
    border-radius: 4px;
    font-weight: 500;
    transition: all 0.2s;
}

.btn-primary:hover {
    background-color: #2980b9;
    transform: translateY(-1px);
}

/* Адаптивные стили */
@media (max-width: 768px) {
    .card-body {
        padding: 15px;
    }
    
    .table {
        font-size: 13px;
    }
    
    .table td, .table th {
        padding: 8px 10px;
    }
}
</style>