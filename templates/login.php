<main class="container pt-5">
    <form method="post" action="/login">
        <?php if($containsError): ?>
            <div class="alert alert-danger">
                The username or password aren't matching.
            </div>
        <?php endif ?>
        <div class="form-group">
            <label for="email">Email address</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email address...">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password...">
        </div>
        <button type="submit" class="btn btn-primary">Login</button>
    </form>
    <div style="padding-top: 20px;text-align:center">
        <a role="button" class="btn btn-info" href="/register">Register</a>
        <a role="button" class="btn btn-info" href="/forgotpass">Forgot password</a>
    </div>
</main>