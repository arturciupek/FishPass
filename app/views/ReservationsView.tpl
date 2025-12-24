{extends file="templates/main.tpl"}

{block name=content}
<header class="major">
  <h1>Moje rezerwacje</h1>
</header>

<div class="table-wrapper">
  <table>
    <thead>
      <tr>
        <th>Kod</th>
        <th>Data</th>
        <th>Wkładka</th>
        <th>Status</th>
        <th>Akcja</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>FP-8K2A1</td>
        <td>2025-12-06</td>
        <td>Dzienna</td>
        <td>Aktywna</td>
        <td>
          <form method="post" action="{$conf->action_root}reservationCancel" style="margin:0;">
            <input type="hidden" name="code" value="FP-8K2A1" />
            <input type="submit" value="Anuluj" class="button cancel" />
          </form>
        </td>
      </tr>
    </tbody>
  </table>
</div>
{/block}
