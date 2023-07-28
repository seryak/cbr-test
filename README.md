
# Парсер курсов ЦБ

Тестовое приложение для получения курсов, кроскурсов ЦБ.
Требования:
- на входе: дата, код валюты, код базовой валюты (по-умолчанию RUR);
- получать курсы с http://cbr.ru;
- на выходе: значение курса и разница с предыдущим торговым днем;
- кешировать данные http://cbr.ru.
- продемонстрировать навыки работы с брокерами сообщений и реализовать сбор данных с cbr за 180 предыдущих дней с помощью воркера через консольную команду.



## Installation

Для запуска приложения требуется Docker и docker-compose.

Перед первым запуском, выполнить команду
```
docker-compose up -d
```

Получить курс валют --currency на дату --date
```
docker-compose run app php index.php --currency=USD --date=2022-05-17
```

Получить кросс-курс валют --currency в базовой валюте --base на дату --date
```
docker-compose run app php index.php --currency=USD --base=EUR --date=2022-05-17
```

Запустить воркер
```
docker-compose run -d app console/run worker
```

Запустить команду на получение курсов за последние 180 дней
```
docker-compose run app console/run last180
```

## Author

- [@Seryak](https://www.github.com/seryak)