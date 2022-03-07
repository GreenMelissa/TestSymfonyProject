Тестовый Symfony проект

### Инструкция к установке

Спульте проект:

```
git clone git@github.com:GreenMelissa/TestSymfonyProject.git
```

Настройте соединение с базой в файле **.env**
```
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name"
```

Установите пакеты:

```
composer install
```

Загрузите тестовые данные для БД
```
php bin/console doctrine:fixtures:load
```

Тестовые данные для пользователей:
```
Логин: user
Пароль: user_password
Роль на сайте: Пользователь
```
```
Логин: admin
Пароль: admin_password
Роль на сайте: Администратор
```

Запустите проект:
```
symfony server:start 
```

Сайт будет доступен по адресу http://localhost:8000
