<style>
    .blogPost .intro {
        position: relative;
        height: 400px;
        background: url('{$post->get("image")}') no-repeat center center;
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
        <div class="container">
            <div class="intro">{$post->get("attrib")}</div>
        </div>

        <div class="content">
            <p><a href="/blog/{$post->get("id")}" class="ion-anchor">View post</a></p>

            <form method="post" action="/compositor/save">
                <input type="text" name="post_title" class="ion-input-text" value="{$post->get("title")}" placeholder="Give your post a name">
                <input type="date" name="post_date" class="ion-input-text" value="{date("Y-m-d", strtotime($post->get("dateUpdate")))}">
                <select name="post_media">
                    {foreach $media as $media_item}
                        <option value="{$media_item}" {if strpos($post->get("image"), $media_item) != -1}selected{/if}>
                        {$media_item} ({\App\MediaLoader::getConfigFromID($media_item, "name")})
                        </option>
                    {/foreach}
                </select>

                <div class="section" style="margin-top: 25px;">
                    {foreach $post->get("categories") as $category}
                        <a href="#" class="postCategory badge">{$category}</a>
                    {/foreach}
                </div>

                <p><i>Articles are written in something called Markdown, read more about it <a class="ion-anchor" target="_blank" href="https://www.markdownguide.org/cheat-sheet">here</a>.</i></p>

                <p class="postContent">
                    <textarea name="content" class="postText ion-input-text" placeholder="## Content">{$post->get("content")}</textarea>
                </p>

                <input type="hidden" name="post_name" value="{$post->get("id")}">
                <input type="hidden" name="post_create" value="{$create_post}">

                <a href="/compositor" class="ion-button ion-btn-default">Cancel</a>
                <input type="submit" class="ion-button ion-btn-primary" value="Save">
            </form>
        </div>

        <div class="container">
            {$footer}
        </div>
    </div>
</div>
