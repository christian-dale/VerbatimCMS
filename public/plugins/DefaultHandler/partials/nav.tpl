{* 
    INTERNAL PAGE DO NOT EDIT!
    If you wish to modify this page, please create
    a copy in content -> pages, and change pages.json to
    the newly created template.
*}

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
            <li><a href="/" class="headerTitle" style="color: #212121;">{$app->getConfigAttr("header_title")}</a></li>
        </ul>
    </nav>

    <nav class="nav-items" style="display: inline-block;">
        <ul>
            {foreach $nav_items as $item}
                <li><a href="{$item["url"]}" 
                    class="navItem navItem{$item["title"]}" style="background-color: {$item["bg-color"]}; color: {$item["color"]};">
                    {$item["title"]}
                </a></li>
            {/foreach}

            {if isset($opts) && $opts["lang"]}
            <li>
                <a href="/set-lang?lang=en&prev={$smarty.server.REQUEST_URI}" class="articleLink badge btnLang" data-lang="en">EN</a>
                <a href="/set-lang?lang=no&prev={$smarty.server.REQUEST_URI}" class="articleLink badge btnLang" data-lang="no">NO</a>
            </li>
            {/if}
        </ul>
    </nav>
</div>
