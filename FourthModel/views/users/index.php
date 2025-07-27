<?php ob_start(); ?>

<h1><?= htmlspecialchars($title) ?></h1>

<?php if (isset($error)): ?>
    <div class="error"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if (empty($users)): ?>
    <div class="no-data">
        <p>Пользователи не найдены</p>
        <p><small>Убедитесь, что таблица 'users' существует и содержит данные</small></p>
    </div>
<?php else: ?>
    <p>Найдено пользователей: <strong><?= count($users) ?></strong></p>

    <?php foreach ($users as $user): ?>
        <div class="user-card">
            <div class="user-name"><?= htmlspecialchars($user['display_name'] ?? $user['name']) ?></div>
            <div class="user-email">📧 <?= htmlspecialchars($user['email']) ?></div>
            <?php if (isset($user['status'])): ?>
                <span class="user-status"><?= htmlspecialchars($user['status']) ?></span>
            <?php endif; ?>
            <?php if (isset($user['created_at'])): ?>
                <div style="font-size: 12px; color: #999; margin-top: 5px;">
                    Регистрация: <?= date('d.m.Y H:i', strtotime($user['created_at'])) ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layout.php';
?>
