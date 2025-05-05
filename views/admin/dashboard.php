<style>
    
    .admin-container {
        max-width: 1200px;
        margin: 30px auto;
        padding: 30px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }
    
    h2 {
        color: #2c3e50;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 1px solid #e9ecef;
        font-weight: 600;
    }
    
    h4 {
        color: #495057;
        margin-bottom: 20px;
        font-weight: 500;
    }
    
    /* Стили таблицы */
    table {
        width: 100%;
        border-collapse: collapse;
        margin: 25px 0;
        font-size: 0.9em;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.03);
    }
    
    thead tr {
        background-color: #3498db;
        color: white;
        text-align: left;
    }
    
    th, td {
        padding: 15px 20px;
    }
    
    th {
        font-weight: 500;
        text-transform: uppercase;
        font-size: 0.8em;
        letter-spacing: 0.5px;
    }
    
    tbody tr {
        border-bottom: 1px solid #e9ecef;
        transition: all 0.2s;
    }
    
    tbody tr:nth-of-type(even) {
        background-color: #f8f9fa;
    }
    
    tbody tr:last-of-type {
        border-bottom: 2px solid #3498db;
    }
    
    tbody tr:hover {
        background-color: #f1f8fe;
    }
    
    /* Стили бейджей */
    .badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 50px;
        font-size: 0.75em;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .bg-danger {
        background-color: #e74c3c;
        color: white;
    }
    
    .bg-primary {
        background-color: #3498db;
        color: white;
    }
    
    /* Стили кнопок */
    .btn {
        display: inline-block;
        padding: 8px 15px;
        border-radius: 4px;
        font-size: 0.8em;
        font-weight: 500;
        text-align: center;
        text-decoration: none;
        transition: all 0.2s;
        border: none;
        cursor: pointer;
    }
    
    .btn-sm {
        padding: 6px 12px;
        font-size: 0.75em;
    }
    
    .btn-warning {
        background-color: #f39c12;
        color: white;
    }
    
    .btn-danger {
        background-color: #e74c3c;
        color: white;
    }
    
    .btn-warning:hover {
        background-color: #e67e22;
        transform: translateY(-1px);
    }
    
    .btn-danger:hover {
        background-color: #c0392b;
        transform: translateY(-1px);
    }
    
    /* Группа кнопок */
    .btn-group {
        display: flex;
        gap: 8px;
    }
    
    /* Адаптивность */
    @media (max-width: 768px) {
        .admin-container {
            padding: 15px;
        }
        
        table {
            display: block;
            overflow-x: auto;
        }
        
        th, td {
            padding: 12px 15px;
        }
    }
</style>

<div class="admin-container">
    <h2>Административная панель</h2>
    
    <div>
        <h4>Пользователи системы</h4>
        
        <table>
            <thead>
               <tr>
                   <th>ID</th>
                   <th>Логин</th>
                   <th>Роль</th>
                   <th>Дата создания</th>
                   <th>Действия</th>
               </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user->id ?></td>
                    <td><?= htmlspecialchars($user->login) ?></td>
                    <td>
                        <span class="badge bg-<?= $user->role === 'admin' ? 'danger' : 'primary' ?>">
                            <?= $user->role ?>
                        </span>
                    </td>
                    <td><?= date('d.m.Y', strtotime($user->created_at)) ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="/users/<?= $user->id ?>/edit" class="btn btn-sm btn-warning">Изменить</a>
                            <a href="/users/<?= $user->id ?>/delete" class="btn btn-sm btn-danger">Удалить</a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>