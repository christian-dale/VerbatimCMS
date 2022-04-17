<div class="contentEditor">
    <div class="container">
        {$nav}

        <h1>Welcome to VerbatimCMS</h1>
        <p>Lets get you started with setting up your website!</p>

        {if \App\Authenticator::isLoggedIn()}
            <h4>Logged in as {\App\Authenticator::getUser()}.</h4>
            <a href="/login?logout=true" class="ion-anchor">Logout</a>
        {/if}

        <label>Send annonymous error logs</label>
        <input type="checkbox" name="usage-statistics" checked>

        {$footer}
    </div>
</div>
