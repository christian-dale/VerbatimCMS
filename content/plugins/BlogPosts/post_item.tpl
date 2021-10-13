<li>
    <div class="intro" style="background: url('{$post->get('image')}') no-repeat center center;">
        <p class="postDate">{$post->get("date")}</p>
    </div>

    <div class="postInfo">
        <p class="postDate">{$post->get("date")}</p>
        <h2 class="postHeader"><a href="/blog/{$post->get("id")}" class="articleLink" style="color: #212121;">{$post->get("title")}</a></h2>
        {foreach $post->get("categories") as $category}
            <a href="#" class="postCategory badge">{$category}</a>
        {/foreach}
        <p class="postContent">{substr(strip_tags($post->get("content")), 0, 150)} ...</p>
        <a href="/blog/{$post->get("id")}" class="articleLink">Read article ...</a>
    </div>
</li>
