# Cycle Columns

[![Latest Stable Version](https://poser.pugx.org/vjik/cycle-columns/v/stable.png)](https://packagist.org/packages/vjik/cycle-columns)
[![Total Downloads](https://poser.pugx.org/vjik/cycle-columns/downloads.png)](https://packagist.org/packages/vjik/cycle-columns)

The package provides:

- `ColumnsManager` that help modify data when mapping in [Cycle ORM](https://cycle-orm.dev/);
- `ColumnInterface` that must be implemented by classes used in `ColumnsManager`;
- classes for `DateTimeImmutable`, `UUID` and `Array` columns.

## Installation

The package could be installed with [composer](https://getcomposer.org/download/):

```shell
composer require vjik/cycle-columns --prefer-dist
```

## General usage

```php
use Cycle\ORM\Mapper\Mapper;
use Cycle\ORM\ORMInterface;
use Vjik\CycleColumns\ColumnsManager;
use Vjik\CycleColumns\ArrayColumn;
use Vjik\CycleColumns\DateTimeImmutableColumn;
use Vjik\CycleColumns\UuidColumn;

final class UserMapper extends Mapper
{
    private ColumnsManager $columnsManager;

    public function __construct(ORMInterface $orm, string $role)
    {
        // Columns manager configuration
        $this->columnsManager = new ColumnsManager([
            'id' => new UuidColumn(UuidColumn::BYTES),
            'create_date' => new DateTimeImmutableColumn(DateTimeImmutableColumn::INTEGER),
            'modify_date' => new DateTimeImmutableColumn(DateTimeImmutableColumn::INTEGER),
            'tags' => new ArrayColumn(','),
        ]);
        
        parent::__construct($orm, $role);
    }

    public function extract($entity): array
    {
        $data = parent::extract($entity);
        
        // Modify data after extract from entity
        $this->columnsManager->afterExtract($data);
        
        return $data;
    }

    public function hydrate($entity, array $data)
    {
        // Modify data before hydrate entity
        $this->columnsManager->beforeHydrate($data);
        
        return parent::hydrate($entity, $data);
    }
}
```

## Testing

### Unit testing

The package is tested with [PHPUnit](https://phpunit.de/). To run tests:

```shell
./vendor/bin/phpunit
```

### Mutation testing

The package tests are checked with [Infection](https://infection.github.io/) mutation framework with
[Infection Static Analysis Plugin](https://github.com/Roave/infection-static-analysis-plugin). To run it:

```shell
./vendor/bin/roave-infection-static-analysis-plugin
```

### Static analysis

The code is statically analyzed with [Psalm](https://psalm.dev/). To run static analysis:

```shell
./vendor/bin/psalm
```

## License

The Cycle Columns is free software. It is released under the terms of the BSD License.
Please see [`LICENSE`](./LICENSE.md) for more information.
