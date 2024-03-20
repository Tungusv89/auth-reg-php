<?php
require_once __DIR__ . '/src/helpers.php';

checkGuest();
?>
<!DOCTYPE html>
<html lang="ru" data-theme="light">
<?php include_once __DIR__ . '/components/head.php' ?>
<body>

<form class="card" action="src/actions/login.php" method="post">
    <h2>Вход</h2>

    <?php if (hasMessage('error')): ?>
        <div class="notice error"><?php echo getMessage('error') ?></div>
    <?php endif ?>
    <div class="notice success">Какое-то сообщение</div>

    <label for="email">
        Email
        <input
                type="text"
                id="email"
                name="email"
                placeholder="Иванов Иван"
                required
                value="<?php echo old('email'); ?>"
            <?php validationErrorAttr('email'); ?>
        >
        <?php if (hasValidationError('email')) : ?>
            <small><?php validationErrorMessage('email'); ?></small>
        <?php endif; ?>
    </label>

    <label for="password">
        Пароль
        <input
                type="password"
                id="password"
                name="password"
                placeholder="******"
                required
        >
    </label>

    <button
            type="submit"
            id="submit"
    >Продолжить
    </button>
</form>

<p>У меня еще нет <a href="/register.php">аккаунта</a></p>

<?php include_once __DIR__ . '/components/scripts.php'?>
</body>
</html>
