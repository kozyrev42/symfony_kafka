<p align="center"><a href="https://symfony.com" target="_blank">
    <img src="https://symfony.com/logos/symfony_dynamic_01.svg" alt="Symfony Logo">
</a></p>

1. Создание нового проекта:
`composer create-project symfony/website-skeleton symfony_kafka`

- Запуск встроенного сервера: 
`php -S localhost:8000 -t public`

2. Созданы Сущность, Репозиторий, Миграция, для дальнейшей работы с Постом.

3. Подключены, настроены пакеты для работы с Kafka.

4. Создан Сервис(и зарегистрирован) и Консольная команда для отправки Сообщений в очередь Кафка.