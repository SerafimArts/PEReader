<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Marshaller\Type;

use Serafim\PEReader\Marshaller\MarshallerInterface;
use Serafim\PEReader\Stream\StreamInterface;
use Spiral\Attributes\NamedArgumentConstructorAttribute;

interface TypeInterface extends NamedArgumentConstructorAttribute
{
    /**
     * @param MarshallerInterface $marshaller
     * @return positive-int|0
     */
    public function bytes(MarshallerInterface $marshaller): int;

    /**
     * @param StreamInterface $stream
     * @param MarshallerInterface $marshaller
     * @return mixed
     */
    public function marshal(StreamInterface $stream, MarshallerInterface $marshaller): mixed;
}
