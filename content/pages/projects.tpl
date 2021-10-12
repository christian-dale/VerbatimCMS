<style>
    .projects {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }

    .projectItem {
        min-width: 250px;
        max-width: 400px;
        background-color: #eee;
        border-radius: 5px;
        color: #212121;
        margin: 25px 0;
        padding: 0 15px 15px 15px;
    }

    @media (max-width: 1200px) {
        .projectItem {
            width: 100%;
			max-width: 100%;
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
            <div class="projectItem">
                <div class="projectContent">
                    <h2>Project</h2>
                    <p>Example text.</p>
                </div>
            </div>
            <div class="projectItem">
                <div class="projectContent">
                    <h2>Project</h2>
                    <p>Example text.</p>
                </div>
            </div>
            <div class="projectItem">
                <div class="projectContent">
                    <h2>Project</h2>
                    <p>Example text.</p>
                </div>
            </div>
            <div class="projectItem">
                <div class="projectContent">
                    <h2>Project</h2>
                    <p>Example text.</p>
                </div>
            </div>
        </div>

        {include file="lib/templates/partials/footer.tpl"}
    </div>
</div>
