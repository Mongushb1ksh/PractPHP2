<h2>Изменение подразделения сотрудника</h2>
<h3><?= $message ?? ''; ?></h3>
<form method="POST" class="form-container">
<input name="csrf_token" type="hidden" value="<?= app()->auth::generateCSRF() ?>"/>
    <div class="form-group">
        <label for="division_id">Новое подразделение</label>
        <select id="division_id" name="division_id">
        <option value="">Выберите подразделение</option>
            <?php foreach ($divisions as $division): ?>
                <option value="<?= $division->division_id ?>"
                    <?= ($request->division_id ?? '') == $division->division_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($division->division_name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        <a href="/dashboard" class="btn btn-link">Отмена</a>
    </div>
</form>
