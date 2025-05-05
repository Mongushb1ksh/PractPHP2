<h2>Дашборд отдела кадров</h2>
<div>
    <h4>Сотрудники по подразделениям</h4>

    <a href="<?= app()->route->getUrl('/employees/create') ?>">Добавить сотрудника</a>
    <table>
        <thead>
            <tr>
                <th>Подразделение</th>
                <th>Кол-во сотрудников</th>
                <th>Средний возраст</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($divisions as $division): ?>
            <tr>
                <td><?= htmlspecialchars($division->division_name) ?></td>
                <td><?= $division->employee_count?></td>
                <td><?= $division->average_age ?></td>
                <td>
                    <a href="/divisions/<?= $division->division_id ?>">Подробнее</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>