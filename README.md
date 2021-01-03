# Cycle Columns

[![Latest Stable Version](https://poser.pugx.org/vjik/cycle-columns/v/stable.png)](https://packagist.org/packages/vjik/cycle-columns)
[![Total Downloads](https://poser.pugx.org/vjik/cycle-columns/downloads.png)](https://packagist.org/packages/vjik/cycle-columns)
[![Build status](https://github.com/vjik/cycle-columns/workflows/build/badge.svg)](https://github.com/vjik/cycle-columns/actions?query=workflow%3Abuild)
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fvjik%2Fcycle-columns%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/vjik/cycle-columns/master)
[![static analysis](https://github.com/vjik/cycle-columns/workflows/static%20analysis/badge.svg)](https://github.com/vjik/cycle-columns/actions?query=workflow%3A%22static+analysis%22)

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

## Columns

### `ArrayColumn`

```php
new ArrayColumn(',');
``` 

Entity value: array of strings. For example, `['A', 'B', 'C']`.

Database value: array concatenated into string with delimiter setted in constructor. For example, `A,B,C`.

### `DateTimeImmutableColumn`

```php
new DateTimeImmutableColumn(DateTimeImmutableColumn::INTEGER);
```

Entity value: `DateTimeImmutable`.

Database value depends on parameter set in constructor:

- `DateTimeImmutableColumn::INTEGER`: timestamp as string (example, `1609658768`).

### `UuidColumn`

```php
new UuidColumn(UuidColumn::BYTES);
```

Entity value: string standard representation of the UUID. For example, `1f2d3897-a226-4eec-bd2c-d0145ef25df9`.

Database value depends on parameter set in constructor:

- `UuidColumn::BYTES`: binary string representation of the UUID.

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
