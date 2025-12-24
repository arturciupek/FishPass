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
      <tr>
        <td>user1@email.pl</td>
        <td>
          <select>
            <option selected>user</option>
            <option>pracownik</option>
            <option>admin</option>
          </select>
        </td>
        <td>
          <a href="#" class="button small primary">Zapisz</a>
        </td>
      </tr>

      <tr>
        <td>pracownik@email.pl</td>
        <td>
          <select>
            <option>user</option>
            <option selected>pracownik</option>
            <option>admin</option>
          </select>
        </td>
        <td>
          <a href="#" class="button small primary">Zapisz</a>
        </td>
      </tr>

      <tr>
        <td>admin@email.pl</td>
        <td>
          <select>
            <option>user</option>
            <option>pracownik</option>
            <option selected>admin</option>
          </select>
        </td>
        <td>
          <a href="#" class="button small primary">Zapisz</a>
        </td>
      </tr>
    </tbody>
  </table>
</div>

{/block}
