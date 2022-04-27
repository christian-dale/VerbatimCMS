<li>
    {if isset($post->get("image")) && $post->get("image") != ""}
        <div class="intro" style="background: url('{$post->get('image')}') no-repeat center center;">
            <p class="postDate">{date("M d, Y", strtotime($post->get("dateUpdate")))}</p>
        </div>
    {/if}

    <div class="postInfo">
        <h2 class="postHeader"><a href="/blog/{$post->get("id")}" class="articleLink" style="color: #212121;">{$post->get("title")}</a></h2>

        {foreach $post->get("categories") as $category}
            <a href="#" class="postCategory badge">{$category}</a>
        {/foreach}

        {if $post->get("lang") != "en"}
            {assign var="postLang" value="lang:"|cat:$post->get("lang")}
            <a href="#" class="postCategory badge" style="background-color: #3a3be9;">{$lang->get($postLang)}</a>
        {/if}

        <p class="postContent">{substr(strip_tags($post->get("content")), 0, 150)} ...</p>
        <a href="/blog/{$post->get("id")}" class="articleLink">Read article ...</a>
    </div>
</li>
