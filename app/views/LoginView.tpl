{extends file="templates/main.tpl"}

{block name=hero}
<section class="hero">
  <div class="hero__bg" style="background-image:url('{$conf->app_url}/images/lowisko2.jpg');"></div>
  <div class="hero__overlay"></div>

  <div class="hero__content">
    <header class="major">
      <h1>Logowanie</h1>
    </header>

    {if isset($msgs) && $msgs->isMessage()}
    {foreach $msgs->getMessages() as $m}
      <div class="hero-msg {if $m->isError()}error{/if}{if $m->isInfo()}info{/if}">
        {$m->text}
      </div>
      {/foreach}
    {/if}

    <form method="post" action="{$conf->action_root}login">
      <div class="row gtr-uniform">
        <div class="col-7">
          <input type="text" name="email" placeholder="Email / login" required />
        </div>
        <div class="col-7">
          <input type="password" name="pass" placeholder="Hasło" required />
        </div>
        <div class="col-7">
          <ul class="actions">
            <li><input type="submit" value="Zaloguj" class="primary" /></li>
          </ul>
        </div>
      </div>
    </form>
  </div>
</section>
{/block}
