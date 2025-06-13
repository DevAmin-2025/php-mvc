<form action="<?= URL_ROOT ?>/user/store" method="post" class="register">
    <fieldset>
        <legend class="register__title">Register</legend>
        <label for="email" class="register__email-label">Email</label>
        <input type="email" id="email" name="email" class="register__email-input">
        <?php if (isset($_SESSION["form_errors"]["email"])): ?>
            <p class="show-error"><?= $_SESSION["form_errors"]["email"] ?></p>
        <?php endif; ?>
        <label for="password" class="register__password-label">Password</label>
        <input type="password" id="password" name="password" class="register__password-input">
        <?php if (isset($_SESSION["form_errors"]["password"])): ?>
            <p class="show-error"><?= $_SESSION["form_errors"]["password"] ?></p>
        <?php endif; ?>
        <label for="confirm-password" class="register__password-label">Password</label>
        <input type="password" id="confirm-password" name="confirm-password" class="register__password-input">
        <?php if (isset($_SESSION["form_errors"]["confirm_password"])): ?>
            <p class="show-error"><?= $_SESSION["form_errors"]["confirm_password"] ?></p>
        <?php endif; ?>
        <?php if (isset($_SESSION["form_errors"])): ?>
            <?php unset($_SESSION["form_errors"]) ?>
        <?php endif; ?>
        <input type="submit" class="register__submit">
    </fieldset>
</form>