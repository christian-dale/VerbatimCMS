<style>
    .blogPost .intro {
        position: relative;
        height: 400px;
        background: url('{$post->get("image")}') no-repeat center center;
        background-size: cover;
        border-radius: 4px;
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
            <h1 style="margin-bottom: 10px;">{$post->get("title")}</h1>
            <h4 style="margin-top: 0;">{date("M d, Y", strtotime($post->get("dateUpdate")))}</h4>

            <div class="section" style="margin-top: 25px;">
                {foreach $post->get("categories") as $category}
                    <a href="#" class="postCategory badge">{$category}</a>
                {/foreach}
            </div>

            <p class="postContent">{$post->get("content")}</p>

            {if isset($disqus_comments)}
                {$disqus_comments}
            {/if}

            {$footer}
        </div>
    </div>
</div>
