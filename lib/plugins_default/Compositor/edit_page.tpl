<style>
    .blogPost .intro {
        position: relative;
        height: 400px;
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

    <h1><a href="/compositor" class="ion-anchor">Compositor</a></h1>
    <p>Edit the posts, pages and plugins of your site.</p>
</div>

<div class="contentBlog">
    <div class="blogPost">
        <div class="content">
            <div class="content">
                <form method="post" action="/compositor/edit-page">
                    <input type="text" name="name" value="{$page["name"]}">
                    <p>You may use smarty tags like {literal}{$nav} and {$footer}{/literal} to get these elements on the page.
                    <hr>
                                        
                    <p>Edit page</p>
                    <textarea name="content" class="postText ion-input-text">{$page["content"]}</textarea>

                    <input type="hidden" name="name" value="{$page["name"]}">
                    <input type="hidden" name="create_page" value="true">
                    <input type="submit" class="ion-button ion-btn-primary" value="Submit">
                    <a href="/compositor/page-delete/{$page["name"]}" class="ion-button ion-btn-default">Delete</a>
                </form>
            </div>

            {$footer}
        </div>
    </div>
</div>
