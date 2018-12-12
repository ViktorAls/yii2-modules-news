**Модуль для создания новостей для сайта**

**Установка**
=
_Предпочтительный способ установки - composer._

php composer.phar require --prefer-dist viktorals/yii2-modules-news "dev-master"

или добавить

"viktorals/yii2-modules-news": "*"

в требуемый раздел вашего composer.json файла.

**Подключение**
=
Добавте: 
`'modules'=>[ 
        'news'=>[ 
            'class'=>'\viktorals\news\Module', 
                ], 
           ],`
 в файле конфигурации вашего проекта. Для попадания на страницу модуля просто перейдите по ссылке ваш_сайт/news, предварительно выполнив миграцию, а также не забудьте по Alias.

Для запуска миграции используйте команду php yii migrate/up --migrationPath=@vendor/viktorals/yii2-modules-news/migrations

**Содержание**
==
Модуль состоит из 2-х частей, добавление постов (заголовок, описание, теги, иконка, основные картинки, отображение (черновик, публикация)) и второй части, добавление и редактирование тегов к новости. По умолчанию пути к сохраняем файлам установлен через alias, для этого добавьте их в bootstrap файл в папке config вашего проекта.

`Yii::setAlias('@icon', dirname(dirname(dirname(__DIR__))).'/public_html/uploads/images/posts/icon/'); - иконки
Yii::setAlias('@images', dirname(dirname(dirname(__DIR__))).'/public_html/uploads/images/posts/post/');- папки постов`

Папка public_html - публичная папка проекта. Если папки uploads/images/posts/icon/ или uploads/images/posts/post/ нету, то она будет создана автоматически. В папке проекта лежит файл стилей, для отображения стилей блоков, подключите его к проекту.

Будет создано 5 таблиц:

 -ImagesManager - для хранения связанных с постом картинок; 

 -Post - хранение постов; 

 -Tag - теги для новостей; 

 -TagPost - связующая таблица постов и тегов; 

 -Worker - таблица с информацией о пользователе который опубликовал пост, она связываться со стандартной таблицей user от yii2 по id; 

В папке img вашего проекта закинете любой файл noimage.jpg в случаи, если картинку поста удалить, то будет отображена noimage.jpg .


P.S.Первый созданный мной и закинутый на git модуль, не судите строго.