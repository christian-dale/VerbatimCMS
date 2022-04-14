<div class="contentEditor">
    <div class="container">
        {$nav}

        <h1>Editore Admin Panel</h1>
        <p>Edit the posts and pages of your site.</p>

        <div class="ion-grid">
            <div class="ion-col-1">
                <h2>Posts</h2>
                <hr>

                <div class="posts">
                    {foreach $posts as $post}
                        <div class="post">
                            <h4><a href="/editore/{$post->get("id")}" class="ion-anchor">{$post->get("title")}</a></h4>
                            <h5>Created: {$post->get("date")}, Updated: {$post->get("dateUpdate")}.</h5>

                            {foreach $post->get("categories") as $category}
                                <a href="#" class="postCategory badge">{$category}</a>
                            {/foreach}
                        </div>
                    {/foreach}
                </div>
            </div>
            <div class="ion-col-1">
                <h2>Pages</h2>
                <hr>

                <div class="pages">
                    {foreach $pages as $page}
                        <div class="page">
                            <h4><a href="{$page["url"]}" class="ion-anchor">{$page["title"]}</a></h4>
                        </div>
                    {/foreach}
                </div>                
            </div>
            <div class="ion-col-1">
                <h2>Plugins</h2>
                <hr>

                <div class="plugins">
                    {foreach $plugins as $plugin}
                        <div class="plugin">
                            <h4><a href="/editore/plugin/" class="ion-anchor">{$plugin["name"]}</a></h4>
                        </div>
                    {/foreach}
                </div>
            </div>
        </div>

        {$footer}
    </div>
</div>
