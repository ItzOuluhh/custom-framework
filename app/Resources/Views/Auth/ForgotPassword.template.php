<?php
Page::setTitle("Wachtwoord vergeten");
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <h1>Wachtwoord vergeten?</h1>
            <form method="post" action="/auth/reset">
                <div class="mb-3">
                    <label for="emailInput" class="form-label">E-mailadres</label>
                    <input type="text" class="form-control" id="emailInput" name="email">
                    <small>Vul je e-mailadres in om je wachtwoord te resetten</small>
                </div>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Verstuur</button>
            </form>
        </div>
    </div>
</div>