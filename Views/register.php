<?php
?>

<h1>register</h1>
<form method="post" action="">
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label for="firstname" class="form-label">first name</label>
                <input type="text" class="form-control" name="firstname">
            </div>
        </div>
        <div class="col">
            <div class="mb-3">
                <label for="lastname" class="form-label">last name</label>
                <input type="text" class="form-control" name="lastname">
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" name="email">
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">password</label>
        <input type="password" class="form-control" name="password">
    </div>
    <div class="mb-3">
        <label for="confirmPassword" class="form-label">confirm password</label>
        <input type="password" class="form-control" name="confirmPassword">
    </div>
    <button type="submit" class="btn btn-primary">register</button>
</form>