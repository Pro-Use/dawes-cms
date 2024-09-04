<main id="main" class="main private-login">
    <form class="login-form" action="<?= $page->url();?>"  method="POST">
        <h2 class="form-heading visuallyhidden">Private Page</h2>
        <div class="input-group">
            <label for="password">Password</label>
            <input type="text" id="password" name="password" required autocomplete="false" spellcheck="false"/>
        </div>
        <button class="button submit-button" aria-label="enter" value="submit">ENTER</button>
        <?php if($error):?>
            <p class="error"><?= $error; ?></p>
        <?php endif;?>
    </form>
</main>