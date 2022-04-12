{* 
    INTERNAL PAGE DO NOT EDIT!
    If you wish to modify this page, please create
    a copy in content -> pages, and change pages.json to
    the newly created template.
*}

<style>
    @media (max-width: 1200px) {
        .contentHome .homeText {
            max-width: 100% !important;
        }

        .intro {
            padding: 5px 10px !important;
        }
    }

    .linkIcon {
        color: #212121;
        text-decoration: none;
        display: inline-block;
        margin-right: 15px;
    }

    .intro {
        padding: 5px 25px;
    }
</style>

<div class="contentHome container">
    {$nav}
    <main>
        <div class="content" style="background: #f3e8e8; border-radius: 5px;">
            <div class="intro">
                <h1>{$app->getConfigAttr("title")}</h1>
                <p class="homeText" style="max-width: 50%;">{$app->getConfigAttr("description")}</p>

                {if isset($additional_template)}
                    {$additional_template}
                {/if}
            </div>
        </div>

        <div class="content">
            {$footer}
        </div>
    </main>
</div>
