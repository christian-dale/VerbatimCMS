# Verbatim CMS

A modular and lightweight Content Management System (CMS).

## About

Verbatim CMS was developed with security as a main focus and priority.
It is also customizable and works with all types of websites.
A true content management system, not only for blogs.

NOTICE: This software is still in beta, so do not use it for anything
with specific security requirements. The project structure and API is subject to change.

Do not edit any files in the 'lib' directory, as these
files will be overwritten when there is an update.

## Why choose Verbatim CMS instead of Wordpress

Wordpress is inherently insecure by design. This
is because of it's directory structure. The webroot of Wordpress
contains all directories to config files, and system files. This has caused
the Wordpress developers to develop hacky solutions like index.php files in all
folders and specialized solutions like htaccess files and custom code to fix these problems.
Verbatim CMS does not have these problems, as the webroot only exposes what the user wants.

Another point to make is that Wordpress needs database access by default, which exposes another
attack vector. Verbatim CMS does support databases, but these are not needed by default, and
can be specificly activated by the user with plugins.

## Philosophy

In Verbatim CMS everything is a plugin. Themes and templates are implemented as plugins.

## Documentation

### Directory structure

Content: Configs, pages and posts.
Public: Files with no access protection, public files.
Lib: Verbatim CMS related files, will be replace on updates.

### Creating new pages

Creating new pages in Verbatim CMS is very simple and
customizable.

In order to create a new page
you must first create a new template file in
content -> pages. Templates use a templating language
called Smarty, which looks very similar to normal HTML pages, but with a few extenstions. Here is an example template:

<pre>
&lt;div class="contentBlog"&gt;
    &lt;div class="container"&gt;
        {$nav}

        &lt;h1&gt;Blog&lt;/h1&gt;
        &lt;p&gt;A blog about technology and philosophy.&lt;/p&gt

        {$footer}
    &lt;/div&gt;
&lt;/div&gt;
</pre>

Read more about smarty [here](https://www.smarty.net/docsv2/en/).

In order to make changes to the home or 404 page, you must first create a page in
content/pages/home.tpl or content/pages/404.tpl respectively.

### Templates

Template file use the .tpl extension, and are stored in the content/pages directory.
Some templates are stored in the lib/templates directory, and can be overwritten
by creating a template file with the same name in the content/pages directory.

### Plugins

Plugins are used to add more functionality to a page.
You can add new plugins to the 'public/plugins' directory.
All plugins require a 'index.php' file.

The folder in lib called plugin_default is just used as a backup
incase the plugins in content are not working. Similar to how
configs_default work.

Homepage is located under:
content/pages/home.tpl
