{extends file="templates/main.tpl"}

{block name=content}
<header class="major">
  <h1>Panel administratora</h1>
</header>

<ul class="actions">
  <li><a class="button primary" href="{$conf->action_root}adminUsersView">Użytkownicy i role</a></li>
  <li><a class="button" href="{$conf->action_root}AdminConfigView">Łowisko / wkładki / stanowiska</a></li>
</ul>
{/block}
