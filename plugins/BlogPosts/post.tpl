<style>
    .blogPost .intro {
        position: relative;
        min-height: 400px;
        background: url('{$post->get("image")}') no-repeat center center fixed;
        background-size: cover;
        border-radius: 4px;
    }
</style>

<div class="container">
    {$nav}
</div>

<div class="contentBlog">
    <div class="blogPost">
        <div class="intro">{$post->get("attrib")}</div>

        <div class="content">
            <h1>{$post->get("title")}</h1>
            <h4>Created at: {$post->get("date")}, Latest update: {$post->get("dateUpdate")}.</h4>

            <div class="section" style="margin-top: 25px;">
                {foreach $post->get("categories") as $category}
                    <a href="#" class="postCategory badge">{$category}</a>
                {/foreach}
            </div>

            <p>{$post->get("content")}</p>

            {$disqus_comments}

            {include file="templates/partials/footer.tpl"}
        </div>
    </div>
</div>
