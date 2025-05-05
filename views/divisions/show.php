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
    
    <a href="/divisions" class="btn btn-primary mt-3">Назад к списку</a>
</div>