{extends file="templates/main.tpl"}

{block name=content}
<header class="major">
  <h1>Moje rezerwacje</h1>
</header>

<form id="search-form" onsubmit="ajaxPostForm('search-form', '{$conf->action_root}reservationsListPart', 'table'); return false;">
  <div class="row gtr-uniform">
    <div class="col-4">
      <select name="status">
        <option value="">Wszystkie</option>
        <option value="AKTYWNA" {if $filtr.status == 'AKTYWNA'}selected{/if}>AKTYWNE</option>
        <option value="ANULOWANA" {if $filtr.status == 'ANULOWANA'}selected{/if}>ANULOWANE</option>
        <option value="ZREALIZOWANA" {if $filtr.status == 'ZREALIZOWANA'}selected{/if}>ZREALIZOWANE</option>
      </select>
    </div>
    <div class="col-4">
      <input type="submit" value="Szukaj" class="button primary" />
    </div>
  </div>
</form>

<div id="table">
  {include file="ReservationsViewTable.tpl"}
</div>

{/block}