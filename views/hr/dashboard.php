<h2>Дашборд отдела кадров</h2>
<div>
    <h4>Сотрудники по подразделениям</h4>
    <h4><a href="<?= app()->route->getUrl('/employee/by_category') ?>">Сотрудники по составу</a></h4>

    <a href="<?= app()->route->getUrl('/employees/create') ?>">Добавить сотрудника</a>
    <a href="<?= app()->route->getUrl('/divisions/create') ?>">Добавить подразделение</a>
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
                <a href="/pop-it-mvc/divisions/show?id=<?= $division->division_id ?>">Подробнее</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</div>


<style>
    /* Основные стили */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f7fa;
        color: #333;
        line-height: 1.6;
    }
    
    .dashboard-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 20px;
        background: white;
        border-radius: 10px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }
    
    h2 {
        color: #2c3e50;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
    }
    
    h4 {
        color: #3498db;
        margin: 25px 0 15px;
    }
    
    /* Стили таблицы */
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 20px 0;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
    }
    
    thead {
        background-color: #3498db;
        color: white;
    }
    
    th {
        padding: 15px;
        text-align: left;
        font-weight: 500;
    }
    
    td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
        vertical-align: middle;
    }
    
    tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Стили кнопок */
    .btn {
        display: inline-block;
        padding: 8px 16px;
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
    
    /* Бейджи для чисел */
    .badge {
        display: inline-block;
        padding: 3px 8px;
        border-radius: 10px;
        font-size: 0.85em;
        font-weight: 500;
    }
    
    .badge-blue {
        background-color: #e1f0fa;
        color: #3498db;
    }
    
    .badge-green {
        background-color: #e1f7ed;
        color: #27ae60;
    }
    
    /* Адаптивность */
    @media (max-width: 768px) {
        .dashboard-container {
            padding: 15px;
        }
        
        th, td {
            padding: 10px;
            font-size: 0.9em;
        }
    }
</style>