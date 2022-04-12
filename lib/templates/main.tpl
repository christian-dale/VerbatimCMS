{* 
    INTERNAL PAGE DO NOT EDIT!
    If you wish to modify this page, please create
    a copy in content -> pages, and change pages.json to
    the newly created template.
*}

<!doctype html>
<html lang="{$lang->getLang()}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{$description}">
    <meta http-equiv="content-language" content="{$lang->getLang()}">

    <title>{$title}</title>

    <link rel="icon" type="image/png" href="/lib/assets/media/favicon.png">
    <link rel="stylesheet" href="/lib/assets/styles/normalize.css">
    <link rel="stylesheet" href="/lib/assets/styles/main.css">

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
