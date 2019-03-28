<nav class="navbar navbar-expand-1g navbar-dark bg-dark">
    <a class="navbar-brand" href="/">My Photos</a>
    <?php if($user["loggedIn"]): ?>

    <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
        <?php esc($user["name"]) ?>
        </button>
        <div class="dropdown-menu">
            <a class="dropdown-item" href="/logout">Logout</a>
            <a class="dropdown-item" href="/profile">Profile</a>
        </div>
    </div>
    <?php else: ?>
    <ul class="navbar-nav pull-right">
        <li class="nav-item active">
            <a class="nav-link" href="/login">Login</a>
        </li>
    </ul>
    <?php endif ?>
</nav>