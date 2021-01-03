<?php

declare(strict_types=1);

namespace Vjik\CycleColumns;

interface ColumnInterface
{
    /**
     * @param mixed $value
     *
     * @return string
     */
    public function afterExtract($value): string;

    /**
     * @param string $value
     *
     * @return mixed
     */
    public function beforeHydrate(string $value);
}
