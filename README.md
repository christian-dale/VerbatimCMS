## portfolio-cms

A portfolio content management system.

### About

This software is still in beta, so do not use it for anything
with specific security requirements.

Do not edit any files in the 'lib' directory, as these
files will be overwritten when there is an update.

## Documentation

### Creating new pages

Creating new pages in portfolio-cms is very simple and
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

### Plugins

Plugins are used to add more functionality to a page.
You can add new plugins to the 'content/plugins' directory.
All plugins require a 'index.php' file.

Homepage is located under:
content/pages/home.tpl
