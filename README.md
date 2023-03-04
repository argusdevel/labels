API-приложение для работы с лейблами.

Лейбл представляет собой текстовую строку, которая может устанавливаться на трёх видах сущностей: 
user, company или website. На сущности может быть указано неограниченное количество лейблов. Все допустимые лейблы 
хранятся в отдельной таблице.

Все запросы тестировались в Postman. Все параметры для работы с приложением передаются в теле 
запроса(body raw(Content-Type: application/json)) вне зависимости от типа запроса.

API-методы для работы с приложением:

- Перезапись лейблов сущности:

  ![Перезапись лейблов сущности](https://github.com/argusdevel/labels/tree/master/public/images/requestsExample/rerecording_labels.PNG)
  
  POST /api/rerecording_labels

  Параметры запроса:

      {
         entity_type (string, required): Тип сущности(может быть только user, company, website),
         entity_id (int, required): Идентификатор сущности,
         labels_list (array): Список лейблов(список идентификаторов лейблов)
      }


- Добавление лейблов к сущности:

  ![Добавление лейблов к сущности](https://github.com/argusdevel/labels/tree/master/public/images/requestsExample/add_labels.PNG)

  PUT /api/add_labels

  Параметры запроса:

      {
         entity_type (string, required): Тип сущности(может быть только user, company, website),
         entity_id (int, required): Идентификатор сущности,
         labels_list (array, required): Список лейблов(список идентификаторов лейблов)
      }


- Удаление лейблов сущности:

  ![Удаление лейблов сущности](https://github.com/argusdevel/labels/tree/master/public/images/requestsExample/delete_labels.PNG)

  DELETE /api/delete_labels

  Параметры запроса:

      {
         entity_type (string, required): Тип сущности(может быть только user, company, website),
         entity_id (int, required): Идентификатор сущности,
         labels_list (array, required): Список лейблов(список идентификаторов лейблов)
      }


- Получение лейблов сущности:

  ![Получение лейблов сущности](https://github.com/argusdevel/labels/tree/master/public/images/requestsExample/get_labels.PNG)

  GET /api/get_labels

  Параметры запроса:

      {
         entity_type (string, required): Тип сущности(может быть только user, company, website),
         entity_id (int, required): Идентификатор сущности
      }

В качестве ответа на успешный запрос возвращается код ответа(первые три метода возвращают код 204, последний - 200) 
и тело ответа(первые три метода возвращают пустое тело ответа, последний - массив с ключом "items" и значением, равным 
массиву с лейблами). В качестве ответа на запрос, в результате которого возникла ошибка, возвращается код ответа 
в зависимости от типа ошибки и в теле ответа находится массив с ключом "message", равным строке с описанием ошибки
