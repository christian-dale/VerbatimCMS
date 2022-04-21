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

            <div class="content">
                <form method="post" action="/compositor/plugin/{$plugin->pluginInfo["name"]}">
                    <label>Enabled</label>
                    <input type="checkbox" name="enabled" {if $plugin_config["enabled"]}checked{/if}>

                    <p>Edit config</p>
                    <textarea name="config" class="postText ion-input-text">{json_encode($plugin_config, JSON_PRETTY_PRINT)}</textarea>
                    <input type="submit" class="ion-button ion-btn-primary" value="Submit">
                </form>
            </div>

            {$footer}
        </div>
    </div>
</div>
