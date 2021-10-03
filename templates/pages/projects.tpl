<style>
    .projects {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .projectItem {
        min-width: 250px;
        max-width: 400px;
        background-color: #3d5afe;
        border-radius: 5px;
        color: #fff;
        margin: 25px 0;
        padding: 0 15px 15px 15px;
    }

    .projectItem a {
        color: #fff;
        text-decoration: none;
    }

    @media (max-width: 1200px) {
        .projectItem {
            width: 100%;
        }
    }
</style>

<div class="contentProjects">
    <div class="container">
        {$nav}
        <h1>Projects</h1>

        <a href="#" class="badge">Customer Projects</a>
        <a href="#" class="badge">My Projects</a>
        <a href="#" class="badge">Small projects / tools</a>

        <h2>Customer Projects</h2>

        <div class="projects" style="">
            <div class="projectItem" style="background: linear-gradient(to right, #59297f, #4e127c);">
                {* <img src="/assets/ptoffice_logo.svg" style="max-width: 200px;"> *}
                <h2>Project</h2>
                <p>Example text.</p>
                <a href="https://google.com">google.com</a>
            </div>
        </div>

        {include file="templates/partials/footer.tpl"}
    </div>
</div>
