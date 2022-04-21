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
                <h1>Login</h1>

                {if isset($first_user)}
                    <h2>Admin login information</h2>
                    <p>Please store for later</p>
                    <p>Username: {$first_user["username"]}</p>
                    <p>Password: {$first_user["password"]}</p>
                {/if}

                <form method="post">
                    <label>Username</label>
                    <input type="username" name="username" class="ion-input-text" value="" placeholder="Enter username">

                    <label>Password</label>
                    <input type="password" name="password" class="ion-input-text" value="" placeholder="Enter password">

                    <input type="submit" class="ion-button ion-btn-primary" value="Login">
                </form>
            </div>
        </div>

        <div class="content">
            {$footer}
        </div>
    </main>
</div>
