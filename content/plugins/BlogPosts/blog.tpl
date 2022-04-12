<style>
    .blogPosts {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-around;
    }
</style>

<div class="contentBlog">
    <div class="container">
        {$nav}

        <h1>Blog</h1>
        <p>A blog about technology and philosophy.</p>

        <ul class="blogPosts" style="padding: 0;">
        {foreach $posts as $post}
            {if $post->get("draft") == false}
                {include file="content/plugins/BlogPosts/post_item.tpl" post=$post}
            {/if}
        {/foreach}
        </ul>

        {$footer}
    </div>
</div>
