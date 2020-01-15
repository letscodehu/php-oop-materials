<main class="container pt-5">
    <form method="post" action="/forgotpass">
        <?php if($sent): ?>
            <div class="alert alert-success">
                We sent an e-mail to the address if it matches an account in our database.
            </div>
            <a role="button" class="btn btn-info" href="/login">Back to login</a>
        <?php else: ?>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email address...">
            </div>
            <button type="submit" class="btn btn-primary">Reset password</button>
        <?php endif ?>
    </form>
</main>