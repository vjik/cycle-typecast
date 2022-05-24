<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast;

use Cycle\ORM\Parser\CastableInterface;
use Cycle\ORM\Parser\UncastableInterface;

abstract class TypecastHandler implements CastableInterface, UncastableInterface
{
    private Typecaster $typecaster;
    private array $supportedKeys;

    public function __construct()
    {
        $config = $this->getConfig();
        $this->supportedKeys = array_keys($config);
        $this->typecaster = new Typecaster($config);
    }

    public function setRules(array $rules): array
    {
        foreach ($rules as $key => $_rule) {
            if (in_array($key, $this->supportedKeys, true)) {
                unset($rules[$key]);
            }
        }

        return $rules;
    }

    public function cast(array $data): array
    {
        return $this->typecaster->prepareBeforeHydrate($data);
    }

    public function uncast(array $data): array
    {
        return $this->typecaster->prepareAfterExtract($data);
    }

    /**
     * @psalm-return array<string, TypeInterface>
     */
    abstract protected function getConfig(): array;
}

