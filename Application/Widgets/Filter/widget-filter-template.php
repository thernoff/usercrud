<form class="form-horizontal form-filter" method="get" action="<?=$uri;?>">
    <div class="form-group">
        <label for="filterLogin" class="control-label">По логину</label>
         <input type="text" class="form-control" id="filterLogin" name="filterLogin" placeholder="Логин">
    </div>
    <div class="form-group">
        <label for="filterLastName" class="control-label">По фамилии </label>
         <input type="text" class="form-control" id="filterLastName" name="filterLastName" placeholder="Фамилия">
    </div>
    <div class="form-group">
        <label for="filterFirstName" class="control-label">По имени</label>
         <input type="text" class="form-control" id="filterFirstName" name="filterFirstName" placeholder="Имя">
    </div>
    <!--<div class="form-group">
        <p><label><input type="radio" name="filterRoleId" value="1"> Администратор</label></p>
        <p><label><input type="radio" name="filterRoleId" value="2"> Пользователь</label></p>

    </div>-->
    <div class="form-group">
        <button type="submit" class="btn btn-filter">Отфильтровать</button>
    </div>
</form>