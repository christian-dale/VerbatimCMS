<style>
    label {
        display: block;
    }
</style>

<div class="contentProjects">
    <div class="container">
        {include file="templates/partials/nav.tpl"}
        <h1>Contact</h1>
        {if $sent}Form was sent.{/if}

        <form action="/contact" method="POST">
            <label>Name</label>
            <input type="text" name="name" placeholder="Enter your name">

            <label>Email</label>
            <input type="text" name="email" placeholder="Enter your email">

            <label>Enter your question</label>
            <textarea name="content"></textarea>

            <input type="submit" value="Send">
        </form>

        {include file="templates/partials/footer.tpl"}
    </div>
</div>
