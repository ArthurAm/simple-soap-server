Простой no-wdsl soap-сервер.

Установка:

Клонируем репозиторий:

```git clone```

Генерим autoload

```composer install```

Заполняем все поля файла ```config/configuration.ini```.
В секции ```SOAP``` указываем ```location``` по которому будет доступен файл ```public/server.php``` 

Запускаем скрипт ```public/install.php```, указываем столько же шардов, сколько прописали в ```config/configuration.ini``` в поле ```shards_count```

Протестировать можно с помощью файла ```public/client.php``` прописав соответствующий ```location```

В клиенте доступны методы 

```getById(int $id)``` - определяет в каком шарде лежит запись с этим ```id``` и возвращает её

```insertToShard(int $id, string $soapText)``` - создает запись в бд.
