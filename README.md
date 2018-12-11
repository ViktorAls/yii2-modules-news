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

	`Yii::setAlias('@icon', dirname(dirname(dirname(__DIR__))).'/public_html/uploads/images/posts/icon/'); - иконки
	Yii::setAlias('@images', dirname(dirname(dirname(__DIR__))).'/public_html/uploads/images/posts/post/');` - папки постов


P.S.Перый созданный мной и закинутый на git modules, не судите строго.