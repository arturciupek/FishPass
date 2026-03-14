{extends file="templates/main.tpl"}

{block name=content}
<header class="major">
  <h1>Terminy</h1>
</header>

<form method="get" action="{rel_url action='termsView'}">
  <div class="row gtr-uniform">
    <div class="col-4">
      <input type="date" name="data_od" value="{$filtr.data_od}" placeholder="Data od" />
    </div>
    <div class="col-4">
      <input type="submit" value="Szukaj" class="button primary" />
    </div>
  </div>
</form>

<div class="table-wrapper">
  <table>
    <thead>
      <tr>
        <th>Data</th>
        <th>Wolne miejsca</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      {foreach $terminy as $t}
        <tr>
          <td>{$t.data}</td>
          <td>{$t.wolne}</td>
          <td>
            {if $t.wolne > 0}
              <a class="button primary small" href="{rel_url action='reservationView' data=$t.data}">Rezerwuj</a>
            {else}
              —
            {/if}
          </td>
        </tr>
      {/foreach}
    </tbody>
  </table>
</div>

<ul class="actions">
  {if $paginacja.jestPoprzednia}
    <li><a class="button" href="{$conf->action_root}termsView?page={$paginacja.stronaPoprzednia}&data_od={$filtr.data_od}">←</a></li>
    <li><a class="button" href="{$conf->action_root}termsView?page={$paginacja.stronaPoprzednia}&data_od={$filtr.data_od}">{$paginacja.stronaPoprzednia}</a></li>
  {/if}

  <li><a class="button primary" href="{$conf->action_root}termsView?page={$paginacja.stronaAktualna}&data_od={$filtr.data_od}">{$paginacja.stronaAktualna}</a></li>

  {if $paginacja.jestNastepna}
    <li><a class="button" href="{$conf->action_root}termsView?page={$paginacja.stronaNastepna}&data_od={$filtr.data_od}">{$paginacja.stronaNastepna}</a></li>
    <li><a class="button" href="{$conf->action_root}termsView?page={$paginacja.stronaNastepna}&data_od={$filtr.data_od}">→</a></li>
  {/if}
</ul>

{/block}