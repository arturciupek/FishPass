{extends file="templates/main.tpl"}

{block name=hero}
<section class="hero">
  <div class="hero__bg" style="background-image:url('{$conf->app_url}/images/lowisko1.jpg');"></div>
  <div class="hero__overlay"></div>

  <div class="hero__content">

    {if isset($user)}
      <div style="margin-bottom: 1rem;">
        Zalogowany: <strong>{$user->email}</strong>
      </div>
    {/if}

    {if isset($messages) && $messages|@count > 0}
      {foreach $messages as $m}
        <div class="box">
          <p><strong>{$m.type|default:'INFO'}:</strong> {$m.text}</p>
        </div>
      {/foreach}
    {/if}

    <header class="major">
      <h1>FishPass</h1>
      <p>Rezerwacja wkładek na łowiska specjalne w całej Polsce.</p>
    </header>

    <ul class="actions">
      <li><a href="{$conf->action_root}termsView" class="button primary">Sprawdź terminy</a></li>

      {if isset($user)}
        <li><a href="{$conf->action_root}reservationsView" class="button">Moje rezerwacje</a></li>
      {else}
        <li><a href="{$conf->action_root}loginView" class="button">Zaloguj się</a></li>
        <li><a href="{$conf->action_root}registerView" class="button">Zarejestruj się</a></li>
      {/if}
    </ul>

    <p>Wybierz termin, zarezerwuj wkładkę i przyjedź łowić — szybko i bez telefonu.</p>

    <hr class="major" />

    <div class="features">
      <article><div class="content"><h3>Terminy</h3><p>Podgląd dostępnych dni i szybkie przejście do rezerwacji.</p></div></article>
      <article><div class="content"><h3>Rezerwacja wkładki</h3><p>Wybór rodzaju wkładki i potwierdzenie rezerwacji w kilku krokach.</p></div></article>
      <article><div class="content"><h3>Moje rezerwacje</h3><p>Lista rezerwacji oraz możliwość anulowania rezerwacji.</p></div></article>
    </div>

  </div>
</section>
{/block}
