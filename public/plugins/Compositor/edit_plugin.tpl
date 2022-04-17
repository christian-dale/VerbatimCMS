<style>
    .blogPost .intro {
        position: relative;
        height: 400px;
        background-size: cover;
        border-radius: 4px;
    }

    .blogPost .postText {
        width: 100%;
        height: 500px;
    }
</style>

<div class="container">
    {$nav}

    <h1><a href="/compositor" class="ion-anchor">Compositor</a></h1>
    <p>Edit the posts, pages and plugins of your site.</p>
</div>

<div class="contentBlog">
    <div class="blogPost">
        <div class="content">
            <h2>{$plugin->pluginInfo["name"]}</h2>
            <hr>

            <p>{$plugin->pluginInfo["description"]}</p>
            <h4>Type: {$plugin->pluginInfo["type"]->value}</h4>
            <h4>Version: {$plugin->pluginInfo["version"]}</h4>
            {if $plugin_config["enabled"]}
                <h4>Enabled: true</h4>
            {else}
                <h4>Enabled: false</h4>
            {/if}

            <div class="content">
                <form method="post" action="/compositor/plugin/{$plugin->pluginInfo["name"]}">
                    {if $plugin_config["enabled"]}
                        <input type="submit" class="ion-button ion-btn-primary" value="Activate">
                    {else}
                        <input type="submit" class="ion-button ion-btn-warning" value="Deactivate">
                    {/if}
                </form>
            </div>

            {$footer}
        </div>
    </div>
</div>
