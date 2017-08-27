Настройка админки
==============

По умолчанию доступ к кабинету администратора осуществляется за счет домена второго уровня.

```
http://admin.{{domain.name}}/
```

или

```
https://admin.{{domain.name}}/
```

Но для того чтобы admin был доступен как контроллер. Необходимо вывести символическую ссылку на backend/web из frontend/web/

Для windows
--------------------
1. Скопировать папку backend/web в frontend/web/
2. Переменовать папку frontend/web/web в frontend/web/admin
3. Изменить путь к корневой папке ($path) в файле  frontend/web/admin/index.php;

```
$path = '../../..';
```

Для linux
--------------------

1. Чтобы создать новую символическую ссылку ввести
```
ln -s /path/to/file /path/to/symlink
``` 
2. Чтобы создать или обновить  символическую ссылку ввести
```
ln -sf /path/to/file /path/to/symlink
``` 

## Итог

Теперь кабинет администратора доступен по ссылке 

```
http://{{domain.name}}/admin
```

или

```
https://{{domain.name}}/admin
```