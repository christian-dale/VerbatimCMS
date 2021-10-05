<style>
    .blogPosts li {
        list-style: none;
        margin: 25px;
        width: 400px;
        background-color: #fafafa;
        border-radius: 4px;
        display: inline-block;
    }

    .blogPosts li .intro {
        position: relative;
        padding: 0 25px;
        height: 250px;
        background-size: cover !important;
        border-radius: 4px;
    }

    .blogPosts li .intro h1 {
        color: #fff;
        text-shadow: 0 1px 1px rgba(0, 0, 0, 0.4);
        position: absolute;
        bottom: 25px;
    }

    .blogPosts li .intro p {
        color: #212121;
        background-color: #eee;
        padding: 0 5px;
        border-radius: 8px;
        position: absolute;
        bottom: 0;
        left: 15px;
    }

    .blogPosts li .postInfo {
        padding: 15px;
    }

    .blogPosts li img {
        width: 100%;
        background-size: cover;
        border-radius: 4px;
        height: 250px;
        object-fit: cover;
    }

    .blogPosts .postHeader {
        margin-top: 35px;
    }

    .blogPosts .postContent {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .blogPosts .postDate {
        font-size: 0.8em;
        margin-top: -50px;
        color: #fff;
    }

    @media (max-width: 1200px) {
        .blogPosts li {
            margin: 25px 0;
        }
    }
</style>

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
