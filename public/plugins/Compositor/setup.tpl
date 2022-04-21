<div class="contentEditor">
    <div class="container">
        {$nav}

        {if isset($settings)}
            <h1><a href="/compositor" class="ion-anchor">Compositor</a></h1>
            </h1>
            <p>Edit the posts, pages and plugins of your site.</p>
            <hr>

            <h2>Settings</h2>
        {else}
            <h1>Welcome to VerbatimCMS</h1>
            <p>Lets get you started with setting up your website!</p>
        {/if}

        {if \App\Authenticator::isLoggedIn()}
            <h4>Logged in as {\App\Authenticator::getUser()}.</h4>
            <a href="/login?logout=true" class="ion-anchor">Logout</a>
        {/if}

        {if isset($config)}
            <form method="post" action="/compositor/setup">
                <label>Send annonymous error logs</label>
                <input type="checkbox" name="usage-statistics" checked>

                <input type="text" placeholder="Title" value="{$config["title"]}" name="title" class="ion-input-text">
                <input type="text" placeholder="Header title" value="{$config["header_title"]}" name="header_title" class="ion-input-text">
                <input type="text" placeholder="Description" value="{$config["description"]}" name="description" class="ion-input-text">
                <input type="text" placeholder="Copyright" value="{$config["copyright"]}" name="copyright" class="ion-input-text">

                <input type="submit" value="Next" class="ion-button ion-btn-primary">
            </form>
        {else}
            <form method="post" action="/compositor/setup">
                <label>Send annonymous error logs</label>
                <input type="checkbox" name="usage-statistics" checked>

                <input type="text" placeholder="Title" name="title" class="ion-input-text">
                <input type="text" placeholder="Header title" name="header_title" class="ion-input-text">
                <input type="text" placeholder="Description" name="description" class="ion-input-text">
                <input type="text" placeholder="Copyright" name="copyright" class="ion-input-text">

                <input type="submit" value="Next" class="ion-button ion-btn-primary">
            </form>
        {/if}

        {$footer}
    </div>
</div>
