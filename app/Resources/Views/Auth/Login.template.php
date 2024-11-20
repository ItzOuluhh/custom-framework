<?php
Page::setTitle("Inloggen");
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-6">
            <h1>Inloggen</h1>
            <form method="post" action="/auth/login">
                <div class="mb-3">
                    <label for="emailInput" class="form-label">Email address</label>
                    <input type="text" class="form-control" id="emailInput" name="email">
                </div>
                <div class="mb-3">
                    <label for="passwordInput" class="form-label">Password</label>
                    <input type="password" class="form-control" id="passwordInput" name="password">
                </div>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?= $error ?>
                    </div>
                <?php endif; ?>
                <button type="submit" class="btn btn-primary">Inloggen</button>
            </form>
        </div>
    </div>
</div>