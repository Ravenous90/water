<div>DB name: water </div>
<div>composer install, update</div>
<div>yii migrate</div>
<div>Краткое описание:</div>
<div>
Регистрация, авторизация пользователей. Две роли - админ, юзер. 
При регистрации по умолчанию - роль юзера. 
(админ: username - admin, password - 123456, генерится при миграции). При миграции также база
заполняется тестовыми данными. 
Роль - админ - может видеть все датчики пользователей с этажами и домами. Может создавать 
дом, этаж, не может создавать датчики.
Роль - юзер, может видеть дома, этажи, датчики на отдельных страницах, при переходе
формируются хлебные крошки с привязкой. Не может создавать дома, этажи, но может создавать
датчики, перейдя на страницу этажа дома. Также есть возможность просмотра своих датчиков.
у незарегистрированных пользователей нет возможности просматривать дома, этажи, датчики, только
регистрация, вход. 
</div>
<div>P.s. Должно все работать, но возможно что-то недотестил</div>

