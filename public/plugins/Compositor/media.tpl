<style>
    .contentMedia .media {
        display: flex;
        flex-wrap: wrap;
    }

    .contentMedia .media .media-item {
        flex: 1;
    }
</style>

<div class="contentMedia">
    <div class="container">
        {$nav}

        <h1><a href="/compositor" class="ion-anchor">Compositor</a></h1>
        <p>Edit the posts, pages and plugins of your site.</p>

        <label>Upload media</label>

        <form method="post" action="/compositor/media" enctype="multipart/form-data">
            <div class="ion-input">
                <input type="file" name="media" accept="image/*">
            </div>

            <input type="submit" class="ion-button ion-btn-primary" value="Submit">
        </form>

        <div class="content">
            <h4>Uploaded media</h4>

            <div class="media">
                {foreach $media as $media_item}
                    <div class="media-item">
                        <img src="/assets/media/{$media_item}" style="width: 250px;">
                    </div>
                {/foreach}
            </div>
        </div>

        {$footer}
    </div>
</div>
