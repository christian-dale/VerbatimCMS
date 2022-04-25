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
        {$blog_config = \App\PluginMan::loadPluginConfig("BlogLux")}
        <p>{$blog_config["description"]}</p>

        <ul class="blogPosts" style="padding: 0;">
        {foreach $posts as $post}
            {if $post->get("draft") == false}
                {include file="public/plugins/BlogLux/post_item.tpl" post=$post}
            {/if}
        {/foreach}
        </ul>

        {$footer}
    </div>
</div>
