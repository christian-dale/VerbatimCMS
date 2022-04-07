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
            </div>
        </div>

        <div class="content">
            {include file="templates/partials/footer.tpl"}
        </div>
    </main>
</div>
