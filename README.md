![Petrovich](https://raw.github.com/rocsci/petrovich/master/petrovich.png)

Склонение падежей русских имён, фамилий и отчеств. Вы задаёте начальное имя в именительном падеже, а получаете в нужном вам.

Портированная версия https://github.com/rocsci/petrovich с ruby на php

Лицензия MIT

## Пример

https://github.com/parshikov/petrovich-php-example

##Установка

Для работы требуется PHP >= 5.3

Загрузить файлы в папку с библиотеками на сервере.

##Использование

В библиотеку входит класс ```Petrovich``` и trait ```Trait_Petrovich```

### Использование класса

```php
require_once('petrovich/Petrovich.php');

use petrovich\Petrovich;

$petrovich = new Petrovich();
$fio = explode(' ',$_REQUEST['fio']);// Пушкин Александр Сергеевич

echo '<br /><strong>Дательный (Кому? Чему?):</strong><br />';
echo $petrovich->firstname($fio[1],Petrovich::CASE_GENITIVE).'<br />';
echo $petrovich->middlename($fio[2],Petrovich::CASE_GENITIVE).'<br />';
echo $petrovich->lastname($fio[0],Petrovich::CASE_GENITIVE).'<br />';
```

### Использование trait'а

Trait содержит в себе
* Свойства
  * ```firstname```
  * ```middlename```
  * ```lastname```
* Методы
  * ```firstname($case)```
  * ```middlename($case)```
  * ```lastname($case)```

```php
require_once('lib/Petrovich.php');
require_once('lib/trait/Petrovich.php');
	
class User {
	use Trait_Petrovich;
}

$user = new User();

$user->lastname = "Пушкин";
$user->firstname = "Александр";
$user->middlename = "Сергеевич";

$user->firstname(Petrovich::CASE_GENITIVE);	// Пушкину
$user->lastname(Petrovich::CASE_GENITIVE);	// Александру
$user->middlename(Petrovich::CASE_GENITIVE);	// Сергеевичу
```

## Падежи
Названия суффиксов для методов образованы от английских названий соответствующих падежей. Полный список поддерживаемых падежей приведён в таблице ниже.

| Суффикс метода | Падеж        | Характеризующий вопрос |
|----------------|--------------|------------------------|
| CASE_GENITIVE  | родительный  | Кого? Чего?            |
| CASE_DATIVE    | дательный    | Кому? Чему?            |
| CASE_ACCUSATIVE| винительный  | Кого? Что?             |
| CASE_INSTRUMENTAL   | творительный | Кем? Чем?              |
| CASE_PREPOSITIONAL  | предложный   | О ком? О чём?          |

## Пол
Свойство ```Petrovich::$gender``` возвращает пол, которому, ВОЗМОЖНО, соответствует последнее запрошеное преобразование.
Для полов определены следующие константы
* GEN_ANDROGYNOUS - пол не определен;
* GEN_MALE - мужской пол;
* GEN_FEMALE - женский пол.
