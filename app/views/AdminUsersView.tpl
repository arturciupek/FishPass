{extends file="templates/main.tpl"}

{block name=content}
<header class="major">
  <h1>Użytkownicy i role</h1>
</header>

<div class="table-wrapper">
  <table>
    <thead>
      <tr>
        <th>Email</th>
        <th>Rola</th>
        <th>Akcja</th>
      </tr>
    </thead>
    <tbody>
      {foreach $users as $u}
        <tr>
          <td>{$u.email}</td>
          <td>
            <form method="post" action="{$conf->action_root}adminChangeRole" style="margin:0;">
              <input type="hidden" name="id_uzytkownika" value="{$u.id_uzytkownika}" />

              <select name="rola">
                <option value="user"   {if $u.role=="user"}selected{/if}>user</option>
                <option value="worker" {if $u.role=="worker"}selected{/if}>pracownik</option>
                <option value="admin"  {if $u.role=="admin"}selected{/if}>admin</option>
              </select>
          </td>
          <td>
              <input type="submit" value="Zapisz" class="button small primary" />
            </form>
          </td>
        </tr>
      {/foreach}
    </tbody>
  </table>
</div>
{/block}
