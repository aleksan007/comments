Тестовое задание для Gaijin

<http://88.212.253.234:8000/>


### Описание

Надо: написать систему комментариев. К произвольному, условному, посту или странице. Комментарии древовидные, уровень вложенности и количество - не ограничены. Надо сделать им и бекенд, и фронтенд. У комментария есть текст и автор. Добавление нового комментария на произвольном уровне вложенности должно происходить без перезагрузки страницы. По умолчанию выводятся комментарии 3х уровней вложенности, остальные скрыты и отображаются по клику. Автор может удалить или отредактировать свои комментарии в течении часа.
 
- на бекенде нужно продемонстрировать паттерн/парадигму MVC, в любом из удобных вариантов, стек - PHP+Mysql (можно golang+mongo; но скажу сразу, "запихать всё дерево в json монги" - так себе план)
- серверные фреймворки использовать можно, если в них нет готовых решений для задачи
- на клиенте - plain js или jquery, без клиентских фреймворков. По верстке можно взять bootstrap или аналоги, сэкономить себе время
- всё это должно работать в современных браузерах, мобильная адаптивка - плюс, отсутствие - не проблема
- гуглить можно, копипастить можно, смотреть в чужой код можно, волнует только качество готового решения
- на выходе должен получиться законченный код (zip с файлами), пригодный для разворачивания на обычном shared-хостинге или vps-ке (если нужна инструкция, надо ее написать; если нужны какие-то проверки или есть грабли - надо их предусмотреть)
- в задаче есть несколько подводных камней; если лень их обрабатывать, то хотя бы на них указать если они важные
- опрятность, лаконичность, и соответствие выбранного инструмента задаче также оценивается
- если решение вдруг занимает больше рабочего дня - то надо вернуться и переосмыслить задание, оно простое. Навскидку, тут час писать и час-полтора допиливать, не надо занаучиваться



### Тестирование
- Нужно скачать этот репозиторий
 ```console
 git clone https://github.com/aleksan007/comments.git
 ```
- Перейти в папку с проектом
- Поднимаем контейнеры. Предварительно должен быть скачен docker и docker-compose
 ```console
 docker-compose up --build
 ```
- Устанавливаем композер:
 ```console
 docker-compose exec web composer install
 ```
- Накатываем миграцию:
 ```console
 docker-compose exec web yii migrate
 ```
- Можно переходить в браузере на <localhost:8000> и тестировать

