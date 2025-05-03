## Фетчер базы данных и страница с поиском

Страница поиска взаимодействует с базой данных, пополненой данными из источников https://jsonplaceholder.typicode.com/posts и https://jsonplaceholder.typicode.com/comments .
Для работы приложения необходимо создать базу данных и две таблицы с помощью SQL запросов:

	CREATE TABLE `posts` (
    `userId` int(11) NOT NULL,
    `id` int(11) NOT NULL,
    `title` text NOT NULL,
    `body` text NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci
    

    CREATE TABLE `commentaries` (
    `postId` int(11) NOT NULL,
    `id` int(11) NOT NULL,
    `name` text NOT NULL,
    `email` text NOT NULL,
    `body` text NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci

После создания необходимо создать файл .env, в который необходимо вставить данные для авторизации в базе данных(см. .env.example). При успешной авторизации необходимо пополнить базу данных с помощью комманды:
    php fetcher.php

После пополнения базы данных можно запустить index.html на веб сервере. На странице есть окно поиска, в которое нужно ввести минимум 3 символа. При нажатии кнопки Поиск страница выведет все комментарии, содержащие искомую строку.
