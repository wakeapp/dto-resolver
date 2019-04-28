DTO Resolver
============

Введение
--------

Компонент предоставляет базовый функционал для безопасной работы с `DTO`. Интерфейсы и базовая реализация обеспечивают
консистентность записанных в `DTO` данных исключая возможность их модификации.
Компонент построен на основе [OptionsResolver](https://github.com/symfony/options-resolver) и позволяет валидировать
и нормальзировать данные, переданные в `DTO`.

Установка
---------

Откройте консоль и, перейдя в директорию проекта, выполните следующую команду для загрузки наиболее подходящей
стабильной версии этого компонента:
```bash
    composer require wakeapp/dto-resolver
```
*Эта команда подразумевает что [Composer](https://getcomposer.org) установлен и доступен глобально.*


Использование
-------------

### Создание DTO

```php
<?php declare(strict_types=1);

namespace AcmeBundle\Dto;

use Wakeapp\Component\DtoResolver\Dto\DtoResolverTrait;
use Wakeapp\Component\DtoResolver\Dto\DtoResolverInterface;

class AcmeUserDto implements DtoResolverInterface
{
    use DtoResolverTrait;
    
    /**
     * @var string
     */
    protected $email;

    /**
     * @var string|null
     */
    protected $fullName = null;

    /**
     * @var string
     */
    protected $username;

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }
}
```

#### Заполнение DTO данными

```php
<?php declare(strict_types=1);

$dto = new AcmeUserDto(['email' => 'test@gmail.com', 'username' => 'test_user', 'fullName' => 'Test User']);

echo $dto->getUsername(); // test_user
echo $dto->getEmail(); // test@gmail.com
echo $dto->getFullName(); // Test User

echo json_encode($dto); // {"email":"test@gmail.com","username":"test_user","fullName":"Test User"}
```

**Внимание:** важной особенностью работы компонеты - является автоматическая нормализация ключей
входящего массива данных. Метод корректно заполнит данные вашего `DTO` даже в тех случаях, когда будут
переданы массива `full-name` или `full_name` вместо `fullName`.

### Добавление валидации данных

```php
<?php declare(strict_types=1);

namespace AcmeBundle\Dto;

use Symfony\Component\OptionsResolver\OptionsResolver;
use Wakeapp\Component\DtoResolver\Dto\DtoResolverInterface;
use Wakeapp\Component\DtoResolver\Dto\DtoResolverTrait;

class AcmeUserDto implements DtoResolverInterface
{
    use DtoResolverTrait;
    
    // ...
    
    /**
     * {@inheritdoc}
     */
    protected function configureOptions(OptionsResolver $options): void
    {
        $options->setRequired(['username']);
        $options->addAllowedTypes('email', ['string', 'null']);
        $options->addAllowedTypes('username', 'string');
    }
}
```

Заполнение DTO данными:

```php
<?php declare(strict_types=1);

$entryDto = new AcmeUserDto(['email' => 'test@gmail.com']); // ошибка: отсутвует обязательное смещение username
$entryDto = new AcmeUserDto(['email' => 123, 'username' => 'test_user']); // ошибка: email имеет недопустимый тип

$entryDto = new AcmeUserDto(['email' => 'test@gmail.com', 'username' => 'test_user']); // успех

echo $entryDto->getUsername(); // test_user
echo $entryDto->getEmail(); // test@gmail.com
```

### Использование коллекций DTO

```php
<?php declare(strict_types=1);

namespace AcmeBundle\Dto;

use Wakeapp\Component\DtoResolver\Dto\CollectionDtoResolverTrait;
use Wakeapp\Component\DtoResolver\Dto\CollectionDtoResolverInterface;

class AcmeUserCollectionDto implements CollectionDtoResolverInterface
{
    use CollectionDtoResolverTrait;
    
    /**
     * {@inheritdoc}
     */
    public static function getItemDtoClassName(): string
    {
        return AcmeUserDto::class;
    }
}
```

Заполнение коллекции DTO данными:

```php
<?php declare(strict_types=1);

/** @var \Wakeapp\Component\DtoResolver\Dto\CollectionDtoResolverInterface $collectionDto */
$collectionDto = new AcmeUserCollectionDto();
$collectionDto->add(['email' => '1_test@gmail.com', 'username' => '1_test_user', 'fullName' => '1 Test User']);
$collectionDto->add(['email' => '2_test@gmail.com', 'username' => '2_test_user', 'fullName' => '2 Test User']);

echo json_encode($collectionDto);
// [
//      {"email":"1_test@gmail.com","username":"1_test_user","fullName":"1 Test User"},
//      {"email":"2_test@gmail.com","username":"2_test_user","fullName":"2 Test User"}
// ]
```

Дополнительно
-------------

### Использование собственного объекта OptionResolver

В случае когда вам необходимо использовать объект `OptionResolver`,
созданный сторонним сервисом - вы можете воспользоваться конструктором.

```php
<?php declare(strict_types=1);

$customResolver = new \Symfony\Component\OptionsResolver\OptionsResolver();
$entryDto = new AcmeUserDto(['email' => 'test@gmail.com'], $customResolver);
$collectionDto = new AcmeUserCollectionDto($customResolver);
```

### Индексирование коллекции по конкретному полю

Поле, по которому необходимо провести индексацию задается вторым аргументов конструктора коллекции.

```php
<?php declare(strict_types=1);

$collectionDto = new AcmeUserCollectionDto(null, 'email');
$collectionDto->add(['email' => '1_test@gmail.com', 'username' => '1_test_user', 'fullName' => '1 Test User']);
$collectionDto->add(['email' => '2_test@gmail.com', 'username' => '2_test_user', 'fullName' => '2 Test User']);
```

Лицензия
--------

![license](https://img.shields.io/badge/License-proprietary-red.svg?style=flat-square)
