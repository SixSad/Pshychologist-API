# Egal project

Установка проекта

    git clone https://github.com/KafedraSputnik/mconnection

Установка зависимостей

    Создайте файл .env и заполните его данными из файла .env.example
    
    Для ОС Windows нужно изменить 
    COMPOSE_FILE=docker-compose.yml:deploy/docker-compose.yml на 
    COMPOSE_FILE=docker-compose.yml;deploy/docker-compose.yml

Установка пакетов

    CMD:
    cd auth-service && composer update --ignore-platform-reqs && cd ..
    cd core-service && composer update --ignore-platform-reqs && cd ..

    PS:
    cd auth-service; composer update --ignore-platform-reqs; cd ..
    cd core-service; composer update --ignore-platform-reqs; cd ..

Запуск проекта

    docker-compose up -d --build

    docker-compose exec auth-service php artisan migrate --seed --force
    docker-compose exec core-service php artisan migrate --seed --force
    

Вспомогательные команды

    Перезапуск контейнера

    docker-compose restart core-service
    docker-compose restart auth-service
    