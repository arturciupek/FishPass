{extends file="templates/main.tpl"}

{block name=content}
<header class="major">
  <h1>Rezerwacje na dzień</h1>
</header>

<form method="get" action="{$conf->action_root}dayView">
  <div class="row gtr-uniform">
    <div class="col-6 col-12-xsmall">
      <label for="date">Data</label>
      <input type="date" id="date" name="date" value="2026-01-10" />
    </div>
    <div class="col-6 col-12-xsmall" style="display:flex; align-items:flex-end;">
      <ul class="actions">
        <li><input type="submit" value="Pokaż" class="button primary" /></li>
      </ul>
    </div>
  </div>
</form>

<hr class="major" />

<div class="table-wrapper">
  <table>
    <thead>
      <tr>
        <th>Kod</th>
        <th>Klient</th>
        <th>Data</th>
        <th>Wkładka</th>
        <th>Status</th>
        <th>Akcje</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>FP-8K2A1</td>
        <td>jan.kowalski@email.pl</td>
        <td>2026-01-10</td>
        <td>Dzienna</td>
        <td>NOWA</td>
        <td>
          <ul class="actions small">
            <li><a href="#" class="button small primary">Potwierdź</a></li>
            <li><a href="#" class="button small">Odrzuć</a></li>
          </ul>
        </td>
      </tr>

      <tr>
        <td>FP-2Z9Q0</td>
        <td>anna.nowak@email.pl</td>
        <td>2026-01-10</td>
        <td>Nocna</td>
        <td>POTWIERDZONA</td>
        <td>
          <ul class="actions small">
            <li><a href="#" class="button small">Odrzuć</a></li>
          </ul>
        </td>
      </tr>
    </tbody>
  </table>
</div>

{/block}
