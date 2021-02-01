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

/**
 * @psalm-template T of object
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Struct implements TypeInterface
{
    /**
     * @param class-string<T> $of
     */
    public function __construct(private string $of)
    {
        if (! \class_exists($this->of)) {
            throw new \InvalidArgumentException(\sprintf('Struct class "%s" not found', $this->of));
        }
    }

    /**
     * {@inheritDoc}
     */
    public function bytes(MarshallerInterface $marshaller): int
    {
        return $marshaller->sizeOf($this->of);
    }

    /**
     * @param StreamInterface $stream
     * @param MarshallerInterface $marshaller
     * @return T
     */
    public function marshal(StreamInterface $stream, MarshallerInterface $marshaller): object
    {
        return $marshaller->marshal($this->of, $stream);
    }
}
