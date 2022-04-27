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

        <h4>Edit lang</h4>

        <form method="post" action="/compositor/media" enctype="multipart/form-data">
            {foreach $lang as $lang_item}
                <label>{$lang_item["name"]}</label>
                <textarea name="content" class="postText ion-input-text" style="height: 250px;">{json_encode($lang_item["lang"], JSON_PRETTY_PRINT)}</textarea>
            {/foreach}

            <input type="submit" class="ion-button ion-btn-primary" value="Submit">
        </form>

        {$footer}
    </div>
</div>
