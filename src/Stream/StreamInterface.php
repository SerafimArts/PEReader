<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Stream;

interface StreamInterface
{
    /**
     * @param positive-int|0 $bytes
     * @return string
     */
    public function read(int $bytes): string;

    /**
     * @param int $offset
     * @return int
     */
    public function move(int $offset): int;

    /**
     * @return positive-int|0
     */
    public function offset(): int;
}
