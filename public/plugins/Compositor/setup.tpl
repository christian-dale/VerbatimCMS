<div class="contentEditor">
    <div class="container">
        {$nav}

        <h1>Welcome to VerbatimCMS</h1>
        <p>Lets get you started with setting up your website!</p>

        {if \App\Authenticator::isLoggedIn()}
            <h4>Logged in as {\App\Authenticator::getUser()}.</h4>
            <a href="/login?logout=true" class="ion-anchor">Logout</a>
        {/if}

        <form method="post" action="/compositor/setup">
            <label>Send annonymous error logs</label>
            <input type="checkbox" name="usage-statistics" checked>

            <input type="text" placeholder="Title" name="title" class="ion-input-text">
            <input type="text" placeholder="Header title" name="header_title" class="ion-input-text">
            <input type="text" placeholder="Description" name="description" class="ion-input-text">
            <input type="text" placeholder="Copyright" name="copyright" class="ion-input-text">

            <input type="submit" value="Next" class="ion-button ion-btn-primary">
        </form>

        {$footer}
    </div>
</div>
