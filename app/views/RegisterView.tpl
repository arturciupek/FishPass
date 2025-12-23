{extends file="templates/main.tpl"}

{block name=hero}
<section class="hero">
  <div class="hero__bg" style="background-image:url('{$conf->app_url}/images/lowisko2.jpg');"></div>
  <div class="hero__overlay"></div>

  <div class="hero__content">
    <header class="major">
      <h1>Rejestracja</h1>
    </header>

    <form method="post" action="{$conf->action_root}register">
      <div class="row gtr-uniform">
        <div class="col-7">
          <input type="text" name="email" placeholder="Email" required />
        </div>
        <div class="col-7">
          <input type="password" name="pass1" placeholder="Hasło" required />
        </div>
        <div class="col-7">
          <input type="password" name="pass2" placeholder="Powtórz hasło" required />
        </div>
        <div class="col-7">
          <ul class="actions">
            <li><input type="submit" value="Utwórz konto" class="primary" /></li>
          </ul>
        </div>
      </div>
    </form>
  </div>
</section>
{/block}
