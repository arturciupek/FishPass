{extends file="templates/main.tpl"}

{block name=content}
<header class="major">
  <h1>Terminy</h1>
</header>

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
              <a class="button primary small" href="{$conf->action_root}reservationView?data={$t.data}">Rezerwuj</a>
            {else}
              —
            {/if}
          </td>
        </tr>
      {/foreach}
    </tbody>
  </table>
</div>
{/block}
