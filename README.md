Автор: Ивченков Андрей @aivchen

### Стек

- Symfony
- RabbitMQ
- Postgres

### Основные инструменты

- Doctrine ORM для работы с доменной моделью
- Symfony Messenger для работы с очередью
- Symfony Event Dispatcher для работы с событиями внутри сервиса

### Запуск проекта:

Замечание: в системе должен быть установлен Docker вместе с Compose Plugin, а также утилита Make.

```shell
make init
```

По-умолчанию запускаются два воркера слушающие очередь `commands`. Настроить количество воркеров можно в файле `docker-compose.yml`.

### Панель управления RabbitMQ

Панель управления очередью доступна по адресу http://localhost:8080.
Логин: `guest`, пароль: `guest`

### База данных

Для подключения к базе данных напрямую с хост системы можно использовать следующие реквизиты:

- Пользователь: `root`
- Пароль: `root`
- Имя бд: `account`
- Адрес: `localhost:5432`

### Очередь команд

Для отправки команд сервису можно воспользоваться панелью управления RabbitMQ.
Очередь для отправки команд называется `commands`: http://localhost:8080/#/queues/%2F/commands

### Формат команд

#### Депозит

```json
{
  "name": "Deposit",
  "id": "1",
  "amount": "100"
}
```

Замечание: если счет не существует, то он будет создан.

#### Списание

```json
{
  "name": "Withdraw",
  "id": "1",
  "amount": "100"
}
```

#### Перевод

```json
{
  "name": "Transfer",
  "from_id": "1",
  "to_id": "2",
  "amount": "100"
}
```

### События

После успешного выполнения команды в очередь `events` отправляется соответсвующее
сообщение: http://localhost:8080/#/queues/%2F/events

Замечание: очередь будет создана после успешного выполнения одной из команд.

### Запуск тестов

```shell
make tests
```

2
