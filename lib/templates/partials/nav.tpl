<style>
    .header {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }
</style>

<div class="header" style="display: flex; justify-content: space-between;">
    <nav class="logo" style="display: inline-block;">
        <ul>
            <li><a href="/" style="color: #212121;">{$app->appname}</a></li>
        </ul>
    </nav>

    <nav class="nav-items" style="display: inline-block;">
        <ul>
            {foreach $nav_items as $item}
                <li><a href="{$item["url"]}" class="navItem" style="background-color: {$item["bg-color"]}; color: {$item["color"]};">{$item["title"]}</a></li>
            {/foreach}
            <li>
                <a href="#" class="articleLink badge btnLang" data-lang="en">EN</a>
                <a href="#" class="articleLink badge btnLang" data-lang="no">NO</a>
            </li>
        </ul>
    </nav>
</div>
