<!DOCTYPE HTML>
<html lang="pl">
<head>
    <title>{$page_title|default:"FishPass — rezerwacja wkładek"}</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="{$conf->app_url}/assets/css/main.css" />
    <noscript><link rel="stylesheet" href="{$conf->app_url}/assets/css/noscript.css" /></noscript>
</head>
<body class="is-preload">

<div id="wrapper">

    <div id="main">

        {* HERO *}
        {block name=hero}{/block}

        {* ZWYKŁA TREŚĆ *}
        <div class="inner">
            {block name=content}{/block}
        </div>

    </div>

    <div id="sidebar">
        <div class="inner">

            <nav id="menu">
                <header class="major">
                    <h2>Menu</h2>
                </header>
                <ul>
                    <li><a href="{$conf->app_url}/index.php">Strona główna</a></li>
                    <li><a href="{$conf->action_root}termsView">Terminy</a></li>

                {*    {if isset($user)} *}
                        <li><a href="{$conf->action_root}reservationsView">Moje rezerwacje</a></li>
                        <li><a href="{$conf->action_root}logout">Wyloguj</a></li>
                {*   {else}   *}
                        <li><a href="{$conf->action_root}loginView">Logowanie</a></li>
                        <li><a href="{$conf->action_root}registerView">Rejestracja</a></li>
                {*    {/if} *}

                    {if isset($roles) && (in_array('pracownik',$roles) || in_array('admin',$roles))}
                        <li>
                            <span class="opener">Panel pracownika</span>
                            <ul>
                                <li><a href="{$conf->action_root}staffDayView">Rezerwacje na dzień</a></li>
                                <li><a href="{$conf->action_root}staffAddReservationView">Dodaj rezerwację</a></li>
                            </ul>
                        </li>
                    {/if}

                    {if isset($roles) && in_array('admin',$roles)}
                        <li>
                            <span class="opener">Administracja</span>
                            <ul>
                                <li><a href="{$conf->action_root}adminUsersView">Użytkownicy i role</a></li>
                                <li><a href="{$conf->action_root}adminConfigView">Łowisko / wkładki / stanowiska</a></li>
                            </ul>
                        </li>
                    {/if}
                </ul>
            </nav>

            <footer id="footer">
                {block name=footer}
                    <p>„Zarezerwuj miejsce na ciszę i ryby!”</p>
                {/block}
            </footer>

        </div>
    </div>

</div>

<script src="{$conf->app_url}/assets/js/jquery.min.js"></script>
<script src="{$conf->app_url}/assets/js/browser.min.js"></script>
<script src="{$conf->app_url}/assets/js/breakpoints.min.js"></script>
<script src="{$conf->app_url}/assets/js/util.js"></script>
<script src="{$conf->app_url}/assets/js/main.js"></script>

</body>
</html>
