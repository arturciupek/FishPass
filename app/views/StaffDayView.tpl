{extends file="templates/main.tpl"}

{block name=content}
<header class="major">
  <h1>Rezerwacje na dzień</h1>
</header>

<form method="get" action="{$conf->action_root}StaffDayView">
  <input type="date" name="data" value="{$data}" />
  <input type="submit" value="Pokaż" class="button" />
</form>

<div class="table-wrapper">
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Data</th>
        <th>Stanowisko</th>
        <th>Wkładka</th>
        <th>Status</th>
        <th>Zmień</th>
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
          <form method="post" action="{$conf->action_root}staffChangeStatus" style="margin:0;">
            <input type="hidden" name="id_rezerwacji" value="{$r.id_rezerwacji}" />
            <input type="hidden" name="data" value="{$data}" />
            <select name="status">
              <option value="NOWA" {if $r.status=="NOWA"}selected{/if}>NOWA</option>
              <option value="POTWIERDZONA" {if $r.status=="POTWIERDZONA"}selected{/if}>POTWIERDZONA</option>
              <option value="ANULOWANA" {if $r.status=="ANULOWANA"}selected{/if}>ANULOWANA</option>
              <option value="ZREALIZOWANA" {if $r.status=="ZREALIZOWANA"}selected{/if}>ZREALIZOWANA</option>
            </select>
            <input type="submit" value="Zapisz" class="button small" />
          </form>
        </td>
      </tr>
      {/foreach}
    </tbody>
  </table>
</div>
{/block}
