<style>
    .projects {
        display: flex;
        flex-wrap: wrap;
        background-color: #e8ebf3;
        border-radius: 5px;
    }

    .projectItem {
        min-width: 250px;
        max-width: 400px;
        border-radius: 5px;
        margin: 25px;
        padding: 0 15px 15px 15px;
        flex-grow: 1;
    }

    .projectItem a {
        text-decoration: none;
    }

    .projectTitle {
        margin-top: 50px;
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
        <p>The following is an example projects page.</p>

        <a href="#customer-projects" class="badge">Customer Projects</a>
        <a href="#my-projects" class="badge">My Projects</a>
        <a href="#small-projects" class="badge">Small projects / tools</a>

        <h2 class="projectTitle" id="customer-projects">Customer Projects</h2>

        <div class="projects">
            <div class="projectItem">
                <h2><a href="https://somaeffects.com" target="_blank">Soma Effects</a></h2>
                <p>Guitar effects web shop, quality items.</p>
            </div>
        </div>

        <h2 class="projectTitle" id="my-projects">My Projects</h2>

        <div class="projects">

        </div>

        <h2 class="projectTitle" id="small-projects">Small projects / tools</h2>

        <div class="projects">

        </div>

        {$footer}
    </div>
</div>
