{extends file="templates/main.tpl"}

{block name=content}
<header class="major">
  <h1>Moje rezerwacje</h1>
</header>

<div class="table-wrapper">
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Data</th>
        <th>Stanowisko</th>
        <th>Wkładka</th>
        <th>Status</th>
        <th>Akcja</th>
      </tr>
    </thead>
    <tbody>
      {foreach $rezerwacje as $r}
        <tr>
          <td>{$r.id_rezerwacji}</td>
          <td>{$r.data_rezerwacji}</td>
          <td>{$r.stanowisko}</td>
          <td>{$r.rodzaj_wkladki}</td>
          <td>{$r.status}</td>
          <td>
            <form method="post" action="{$conf->action_root}reservationCancel" style="margin:0;">
              <input type="hidden" name="id_rezerwacji" value="{$r.id_rezerwacji}" />
              <input type="submit" value="Anuluj" class="button" />
            </form>
          </td>
        </tr>
      {/foreach}
    </tbody>
  </table>
</div>
{/block}
