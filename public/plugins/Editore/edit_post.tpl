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
</div>

<div class="contentBlog">
    <div class="blogPost">
        <div class="container">
            <div class="intro">{$post->get("attrib")}</div>
        </div>

        <div class="content">
            <input type="text" class="ion-input-text" value="{$post->get("title")}" placeholder="Give your post a name">
            <input type="date" class="ion-input-text" value="{date("Y-m-d", strtotime($post->get("dateUpdate")))}">

            <div class="section" style="margin-top: 25px;">
                {foreach $post->get("categories") as $category}
                    <a href="#" class="postCategory badge">{$category}</a>
                {/foreach}
            </div>

            <p><i>Articles are written in something called Markdown, read more about it <a class="ion-anchor" target="_blank" href="https://www.markdownguide.org/cheat-sheet">here</a>.</i></p>

            <p class="postContent">
                <textarea class="postText ion-input-text">
                    {$post->get("content")}
                </textarea>
            </p>

            <div class="content">
                <input type="submit" class="ion-button ion-btn-default" value="Cancel">
                <input type="submit" class="ion-button ion-btn-primary" value="Save">
            </div>

            {if isset($disqus_comments)}
                {$disqus_comments}
            {/if}

            {$footer}
        </div>
    </div>
</div>
