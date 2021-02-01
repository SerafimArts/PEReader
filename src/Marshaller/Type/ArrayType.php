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

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class ArrayType implements TypeInterface
{
    /**
     * @var TypeInterface
     */
    private TypeInterface $type;

    /**
     * @param positive-int $size
     * @param class-string<TypeInterface> $of
     * @param array<int|string, mixed> $args
     * @throws \ReflectionException
     */
    public function __construct(private int $size, string $of, array $args = [])
    {
        /** @psalm-suppress InvalidScalarArgument */
        $this->type = (new \ReflectionClass($of))->newInstanceArgs($args);
    }

    /**
     * {@inheritDoc}
     */
    public function bytes(MarshallerInterface $marshaller): int
    {
        return $this->type->bytes($marshaller) * $this->size;
    }

    /**
     * @param StreamInterface $stream
     * @param MarshallerInterface $marshaller
     * @return array<array-key, mixed>
     */
    public function marshal(StreamInterface $stream, MarshallerInterface $marshaller): array
    {
        $result = [];

        for ($i = 0; $i < $this->size; ++$i) {
            /** @psalm-suppress MixedAssignment */
            $result[] = $this->type->marshal($stream, $marshaller);
        }

        return $result;
    }
}
