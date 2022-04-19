{*
    INTERNAL PAGE DO NOT EDIT!
    If you wish to modify this page, please create
    a copy in content -> pages, and change pages.json to
    the newly created template.
*}

<!doctype html>
<html {if $app->pluginExists("Lang")}lang="{$app->getPlugin('Lang')->getLang($app)}"{/if}>

<head>
    <!-- Created with Verbatim CMS -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{$description}">
    {if $app->pluginExists("Lang")}
    <meta http-equiv="content-language" content="{$app->getPlugin('Lang')->getLang($app)}">
    {/if}
    {foreach $app->custom_meta as $meta}
        <meta name="{$meta["name"]}" content="{$meta["content"]}">
    {/foreach}

    <title>{$app->getTitle()}</title>

    <link rel="icon" type="image/png" href="/assets/favicon.png">

    {foreach $css_paths as $css_path}
        <link rel="stylesheet" href="{$css_path}">
    {/foreach}
</head>

<body>
    {$content}

    {foreach $js_paths as $js_path}
        <script src="{$js_path}"></script>
    {/foreach}
</body>

</html>
