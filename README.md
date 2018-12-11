Новостной модуль для yii2
====================
Модуль для создания новостей для сайта

Установка
------------

Предпочтительный способ установки - [composer](http://getcomposer.org/download/).

```
php composer.phar require --prefer-dist viktorals/yii2-modules-news "*"
```

или добавить

```
"viktorals/yii2-modules-news": "*"
```

в требуемый раздел вашего composer.json файла.

**Содержание**
===============

Модуль состоит из 2-х частей, добавление постов (заголовок, описание, теги, иконка,основные картинки, отображение (черновки, публикация))
и второй части, добавление и редактирование тегов к новости. 
По умолчанию пути к сохраняем файлам установлен через alias, для этого добавте их в bootstrap файл в папке config вашего проекта.

	Yii::setAlias('@icon', dirname(dirname(dirname(__DIR__))).'/public_html/uploads/images/posts/icon/'); - иконки
	Yii::setAlias('@images', dirname(dirname(dirname(__DIR__))).'/public_html/uploads/images/posts/post/');` - папки постов
     
Папка `public_html` - пбличная папка проекта. Если папки `uploads/images/posts/icon/` или `uploads/images/posts/post/` нету, то она будет создана автоматически.
В папке поекта лежит файл стилей, для отображения стилей блоков, подключите его к проексту.

Для запуска миграции используйте команду
`php yii migrate/up --migrationPath=@vendor/viktorals/yii2-modules-news/migrations`

Будеи создано 5 таблиц 
`ImagesManager` - для хронения связанных с постом картинок 
`Post` - хранение постов
`Tag` - теги для новостей
`TagPost` - связующая таблица постов и тегов
`Worker` - таблица с информациеей о полозователе который опубликовал пост, она связываеться со стандартной таблицей user от yii2 по id


P.S.Перый созданный мной и закинутый на git modules, не судите строго.

