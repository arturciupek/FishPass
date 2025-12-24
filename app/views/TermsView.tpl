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
      <tr>
        <td>2025-12-06</td>
        <td>7</td>
        <td><a class="button primary small" href="{$conf->action_root}reservationView">Rezerwuj</a></td>
      </tr>
    </tbody>
  </table>
</div>
{/block}
