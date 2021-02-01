<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Marshaller;

use Serafim\PEReader\Stream\StreamInterface;

interface MarshallerInterface
{
    /**
     * @psalm-template T of object
     *
     * @param T|class-string<T> $struct
     * @param StreamInterface $stream
     * @return T
     */
    public function marshal(object|string $struct, StreamInterface $stream): object;

    /**
     * @param object|class-string $struct
     * @return int
     */
    public function sizeOf(object|string $struct): int;
}
