Find By Attribute
=================
Allowed to use magic methods for finding active records by attributes

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist bigdropinc/yii2-find-by-attribute "*"
```

or add

```
"bigdropinc/yii2-find-by-attribute": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Add into your base Active Record method like this

```
use bigdropinc\db\FindByAttribute

public static function __callStatic($name, $arguments)
    {
        if(static::isFindByCanProcess($name)){
            return static::processFindBy($name, $arguments);
        }
    }
```