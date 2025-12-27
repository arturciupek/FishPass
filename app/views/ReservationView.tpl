{extends file="templates/main.tpl"}

{block name=content}
<header class="major">
  <h1>Rezerwacja wkładki</h1>
  <p>Wybierz dane rezerwacji.</p>
</header>

<form method="post" action="{$conf->action_root}addReservation">
  <div class="row gtr-uniform">

    <div class="col-6 col-12-xsmall">
      <label>Data</label>
      <input type="date" name="data_rezerwacji" value="{$data|default:''}" required />
    </div>

    <div class="col-6 col-12-xsmall">
      <label>Stanowisko</label>
      <select name="stanowisko_id_stanowiska" required>
        <option value="">— wybierz —</option>
        {foreach $stanowiska as $s}
          <option value="{$s.id_stanowiska}">{$s.kod}</option>
        {/foreach}
      </select>
    </div>

    <div class="col-6 col-12-xsmall">
      <label>Rodzaj wkładki</label>
      <select name="rodzaj_wkladki_id_rodzaju_wkladki" required>
        <option value="">— wybierz —</option>
        {foreach $wkladki as $w}
          <option value="{$w.id_rodzaju_wkladki}">{$w.nazwa} ({$w.cena} zł)</option>
        {/foreach}
      </select>
    </div>

    <div class="col-12">
      <ul class="actions">
        <li><input type="submit" value="Zarezerwuj" class="primary" /></li>
        <li><a class="button" href="{$conf->action_root}termsView">Wróć</a></li>
      </ul>
    </div>

  </div>
</form>
{/block}
