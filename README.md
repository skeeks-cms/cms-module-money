Module for working with money and currency
===================================

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist skeeks/cms-module-money "*"
```

or add

```
"skeeks/cms-module-money": "*"
```

Configuration app
----------

```php

'components' =>
[
 'money' => [
     'class'         => 'skeeks\modules\cms\money\components\money\Money',
 ],
 'i18n' => [
     'translations' =>
     [
         'skeeks/money' => [
             'class'             => 'yii\i18n\PhpMessageSource',
             'basePath'          => '@skeeks/modules/cms/money/messages',
             'fileMap' => [
                 'skeeks/money' => 'main.php',
             ],
         ]
     ]
 ],
],
'modules' =>
[
    'money' => [
        'class'         => 'skeeks\modules\cms\money\Module',
    ]
]

```

##Links
* [Web site](http://en.cms.skeeks.com)
* [Web site (rus)](http://cms.skeeks.com)
* [Author](http://skeeks.com)
* [ChangeLog](https://github.com/skeeks-cms/cms-module-money/blob/master/CHANGELOG.md)



Игформация о модуле
-------------------

Модуль для работы с деньгами и валютой.
За основу данного модуля, была взята библиотека https://github.com/sebastianbergmann/money, но ее пришлось изрядно допилить. Поэтому в чистом виде она не была подключена.

Основная работа была в том, чтобы появилась некоторая прозрачная работа с деньгами.
Типичны пример, который мы прозрачно решаем в этой библиотеке.
(10$ + 154руб + 12$) = рузальтат нужно показать в GBP, для de_DE локали

Сразу пример:

```
use \skeeks\modules\cms\money\Money;
use \skeeks\modules\cms\money\IntlFormatter;

$money  = Money::fromString('10', "USD");
$money2 = Money::fromString('154', "EUR");
$money3 = Money::fromString('12', "EUR");

$money = $money->add($money2);
$money = $money->add($money3);

$money = $money->convertToCurrency('GBP');

$formatter = new IntlFormatter('de_DE');
$formatter->format($money); //результат 132,25 £

```

Установка
------------

1) Стандартная установка через composer

```
php composer.phar require --prefer-dist skeeks/cms-module-money "*"
```

or add

```
"skeeks/cms-module-money": "*"
```

to the require section of your `composer.json` file.


2) Установка миграций

```
 php yii migrate --migrationPath=vendor/skeeks/cms-module-money/migrations
```

# Примеры и использование

## Оригинальные примеры

#### Creating a Money object and accessing its monetary value

```php
use skeeks\cms\modules\money\Currency;
use skeeks\cms\modules\money\Money;

// Create Money object that represents 1 EUR
$m = new Money(100, new Currency('EUR'));

// Access the Money object's monetary value
print $m->getAmount();
```

The code above produces the output shown below:

    100

#### Creating a Money object from a string value

```php
use skeeks\cms\modules\money\Currency;
use skeeks\cms\modules\money\Money;

// Create Money object that represents 12.34 EUR
$m = Money::fromString('12.34', new Currency('EUR'))

// Access the Money object's monetary value
print $m->getAmount();
```

The code above produces the output shown below:

    1234

#### Using a Currency-specific subclass of Money

```php
use skeeks\cms\modules\money\EUR;

// Create Money object that represents 1 EUR
$m = new EUR(100);

// Access the Money object's monetary value
print $m->getAmount();
```

The code above produces the output shown below:

    100

Please note that there is no subclass of `Money` that is specific to Turkish Lira as `TRY` is not a valid class name in PHP.

#### Formatting a Money object using PHP's built-in NumberFormatter

```php
use skeeks\cms\modules\money\Currency;
use skeeks\cms\modules\money\Money;
use skeeks\cms\modules\money\IntlFormatter;

// Create Money object that represents 1 EUR
$m = new Money(100, new Currency('EUR'));

// Format a Money object using PHP's built-in NumberFormatter (German locale)
$f = new IntlFormatter('de_DE');

print $f->format($m);
```

The code above produces the output shown below:

    1,00 €

#### Basic arithmetic using Money objects

```php
use skeeks\cms\modules\money\Currency;
use skeeks\cms\modules\money\Money;

// Create two Money objects that represent 1 EUR and 2 EUR, respectively
$a = new Money(100, new Currency('EUR'));
$b = new Money(200, new Currency('EUR'));

// Negate a Money object
$c = $a->negate();
print $c->getAmount();

// Calculate the sum of two Money objects
$c = $a->add($b);
print $c->getAmount();

// Calculate the difference of two Money objects
$c = $b->subtract($a);
print $c->getAmount();

// Multiply a Money object with a factor
$c = $a->multiply(2);
print $c->getAmount();
```

The code above produces the output shown below:

    -100
    300
    100
    200

#### Comparing Money objects

```php
use skeeks\cms\modules\money\Currency;
use skeeks\cms\modules\money\Money;

// Create two Money objects that represent 1 EUR and 2 EUR, respectively
$a = new Money(100, new Currency('EUR'));
$b = new Money(200, new Currency('EUR'));

var_dump($a->lessThan($b));
var_dump($a->greaterThan($b));

var_dump($b->lessThan($a));
var_dump($b->greaterThan($a));

var_dump($a->compareTo($b));
var_dump($a->compareTo($a));
var_dump($b->compareTo($a));
```

The code above produces the output shown below:

    bool(true)
    bool(false)
    bool(false)
    bool(true)
    int(-1)
    int(0)
    int(1)

The `compareTo()` method returns an integer less than, equal to, or greater than
zero if the value of one `Money` object is considered to be respectively less
than, equal to, or greater than that of another `Money` object.

You can use the `compareTo()` method to sort an array of `Money` objects using
PHP's built-in sorting functions:

```php
use skeeks\cms\modules\money\Currency;
use skeeks\cms\modules\money\Money;

$m = array(
    new Money(300, new Currency('EUR')),
    new Money(100, new Currency('EUR')),
    new Money(200, new Currency('EUR'))
);

usort(
    $m,
    function ($a, $b) { return $a->compareTo($b); }
);

foreach ($m as $_m) {
    print $_m->getAmount() . "\n";
}
```

The code above produces the output shown below:

    100
    200
    300

#### Allocate the monetary value represented by a Money object among N targets

```php
use skeeks\cms\modules\money\Currency;
use skeeks\cms\modules\money\Money;

// Create a Money object that represents 0,99 EUR
$a = new Money(99, new Currency('EUR'));

foreach ($a->allocateToTargets(10) as $t) {
    print $t->getAmount() . "\n";
}
```

The code above produces the output shown below:

    10
    10
    10
    10
    10
    10
    10
    10
    10
    9

#### Allocate the monetary value represented by a Money object using a list of ratios

```php
use skeeks\cms\modules\money\Currency;
use skeeks\cms\modules\money\Money;

// Create a Money object that represents 0,05 EUR
$a = new Money(5, new Currency('EUR'));

foreach ($a->allocateByRatios(array(3, 7)) as $t) {
    print $t->getAmount() . "\n";
}
```

The code above produces the output shown below:

    2
    3

#### Extract a percentage (and a subtotal) from the monetary value represented by a Money object

```php
use skeeks\cms\modules\money\Currency;
use skeeks\cms\modules\money\Money;

// Create a Money object that represents 100,00 EUR
$original = new Money(10000, new Currency('EUR'));

// Extract 21% (and the corresponding subtotal)
$extract = $original->extractPercentage(21);

printf(
    "%d = %d + %d\n",
    $original->getAmount(),
    $extract['subtotal']->getAmount(),
    $extract['percentage']->getAmount()
);
```

The code above produces the output shown below:

    10000 = 8265 + 1735

Please note that this extracts the percentage out of a monetary value where the
percentage is already included. If you want to get the percentage of the
monetary value you should use multiplication (`multiply(0.21)`, for instance,
to calculate 21% of a monetary value represented by a Money object) instead.





[Страница на SkeekS CMS Marketplace](http://marketplace.cms.skeeks.com/solutions/instrumentyi/razrabotchiku/13-modul-valyutyi_dengi)


> [![skeeks!](https://gravatar.com/userimage/74431132/13d04d83218593564422770b616e5622.jpg)](http://skeeks.com)  
<i>SkeekS CMS (Yii2) — быстро, просто, эффективно!</i>  
[skeeks.com](http://skeeks.com) | [cms.skeeks.com](http://cms.skeeks.com) | [marketplace.cms.skeeks.com](http://marketplace.cms.skeeks.com)
