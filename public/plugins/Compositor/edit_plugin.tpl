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
                <input type="submit" class="ion-button ion-btn-primary" value="Activate">
            </div>

            {$footer}
        </div>
    </div>
</div>
