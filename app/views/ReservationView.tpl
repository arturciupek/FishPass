{extends file="templates/main.tpl"}

{block name=content}
<header class="major">
  <h1>Rezerwacja wkładki</h1>
  <p>Wybierz dane rezerwacji.</p>
</header>

<form method="post" action="{$conf->action_root}reservationSave">
  <div class="row gtr-uniform">

    <div class="col-6 col-12-xsmall">
      <label>Data</label>
      <input type="date" name="date" value="{$date|default:''}" required />
    </div>

    <div class="col-6 col-12-xsmall">
      <label>Rodzaj wkładki</label>
      <select name="permit_id" required>
        <option value="">— wybierz —</option>
        <option value="1">Dzienna</option>
        <option value="2">Nocna</option>
      </select>
    </div>

    <div class="col-6 col-12-xsmall">
      <label>Liczba wkładek</label>
      <input type="number" name="qty" min="1" max="5" value="1" required />
    </div>

    <div class="col-6 col-12-xsmall">
      <label>Kontakt</label>
      <input type="text" name="contact" placeholder="Email lub telefon" required />
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
