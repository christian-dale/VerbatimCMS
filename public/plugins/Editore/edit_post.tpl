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
            <input type="text" value="{$post->get("title")}">
            <input type="date" value="{date("Y-m-d", strtotime($post->get("dateUpdate")))}">

            <div class="section" style="margin-top: 25px;">
                {foreach $post->get("categories") as $category}
                    <a href="#" class="postCategory badge">{$category}</a>
                {/foreach}
            </div>

            <p class="postContent">
                <textarea class="postText">
                    {$post->get("content")}
                </textarea>
            </p>

            {if isset($disqus_comments)}
                {$disqus_comments}
            {/if}

            {$footer}
        </div>
    </div>
</div>
