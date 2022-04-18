<div class="contentEditor">
    <div class="container">
        {$nav}

        <h1><a href="/compositor" class="ion-anchor">Compositor</a></h1>
        <p>Edit the posts, pages and plugins of your site.</p>

        {if \App\Authenticator::isLoggedIn()}
            <h4>Logged in as {\App\Authenticator::getUser()}.</h4>
            <a href="/login?logout=true" class="ion-anchor">Logout</a>
        {/if}

        <p><a href="/compositor/media" class="ion-anchor">Manage media</a></p>
        <p><a href="/compositor/lang" class="ion-anchor">Manage language</a></p>

        <div class="ion-grid">
            <div class="ion-col-1">
                <h2>Posts</h2>
                <hr>

                <div class="posts">
                    {foreach $posts as $post}
                        <div class="post">
                            <h4><a href="/compositor/view-post/{$post->get("id")}" class="ion-anchor">{$post->get("title")}</a></h4>
                            <h5>Created: {$post->get("date")}, Updated: {$post->get("dateUpdate")}.</h5>

                            {foreach $post->get("categories") as $category}
                                <a href="#" class="postCategory badge">{$category}</a>
                            {/foreach}
                        </div>
                    {/foreach}

                    <a href="/compositor/create-post" class="ion-button ion-btn-primary" style="margin-top: 25px;">Create Post</a>
                </div>
            </div>
            <div class="ion-col-1">
                <h2>Pages</h2>
                <hr>

                <div class="pages">
                    {foreach $pages as $page}
                        <div class="page">
                            <h4><a href="/compositor/page{$page["url"]}" class="ion-anchor">{$page["title"]}</a></h4>
                        </div>
                    {/foreach}

                    <a href="/compositor/page" class="ion-button ion-btn-primary" style="margin-top: 25px;">Create Page</a>
                </div>
            </div>
            <div class="ion-col-1">
                <h2>Plugins</h2>
                <hr>

                <div class="plugins">
                    {foreach $plugins as $plugin}
                        <div class="plugin">
                            <h4><a href="/compositor/plugin/{$plugin["name"]}" class="ion-anchor">{$plugin["name"]}</a>
                            ({$plugin["type"]->value})
                            </h4>
                        </div>
                    {/foreach}
                </div>
            </div>
            {* <div class="ion-col-1">
                <h2>Media</h2>
                <hr>

                <div class="media">
                    {foreach $media as $media_item}
                        <div class="media-item">
                            <img src="/assets/media/{$media_item}" style="max-width: 100%;">
                        </div>
                    {/foreach}

                    <a href="/compositor/media" class="ion-button ion-btn-primary" style="margin-top: 25px;">Upload media</a>
                </div>
            </div> *}
        </div>

        {$footer}
    </div>
</div>
