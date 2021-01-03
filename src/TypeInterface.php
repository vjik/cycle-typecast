<?php

declare(strict_types=1);

namespace Vjik\CycleTypecast;

interface TypeInterface
{
    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function convertToDatabaseValue($value);

    /**
     * @param mixed $value
     *
     * @return mixed
     */
    public function convertToPhpValue($value);
}
