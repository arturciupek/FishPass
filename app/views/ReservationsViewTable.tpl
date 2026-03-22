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

<ul class="actions">
  {if $paginacja.jestPoprzednia}
    <li><a class="button" href="{$conf->action_root}reservationsList?page={$paginacja.stronaPoprzednia}&status={$filtr.status}">←</a></li>
    <li><a class="button" href="{$conf->action_root}reservationsList?page={$paginacja.stronaPoprzednia}&status={$filtr.status}">{$paginacja.stronaPoprzednia}</a></li>
  {/if}

  <li><a class="button primary" href="{$conf->action_root}reservationsList?page={$paginacja.stronaAktualna}&status={$filtr.status}">{$paginacja.stronaAktualna}</a></li>

  {if $paginacja.jestNastepna}
    <li><a class="button" href="{$conf->action_root}reservationsList?page={$paginacja.stronaNastepna}&status={$filtr.status}">{$paginacja.stronaNastepna}</a></li>
    <li><a class="button" href="{$conf->action_root}reservationsList?page={$paginacja.stronaNastepna}&status={$filtr.status}">→</a></li>
  {/if}
</ul>