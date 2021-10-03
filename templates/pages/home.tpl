<style>
    @media (max-width: 1200px) {
        .contentHome .homeText {
            max-width: 100% !important;
        }
    }
</style>

<div class="contentHome container">
    {$nav}
    <main>
        <div class="content" style="padding: 2px 0;">
            <h1>Title</h1>
            <p class="homeText" style="max-width: 50%;">Example</p>
        </div>

        <div class="content" style="padding: 0; {*background-color: #fce4ec;*}">
        {* <img src="/assets/ptoffice_logo.svg" style="max-width: 200px;"> *}
        <!--
            <h1>Projects</h1>
            <p style="max-width: 50%;">A curated list of featured projects.</p>
            -->
        </div>
        <div class="content">
            {include file="templates/partials/footer.tpl"}
        </div>
    </main>
</div>
