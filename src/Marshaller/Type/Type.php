<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Marshaller\Type;

use JetBrains\PhpStorm\ExpectedValues;
use Serafim\PEReader\Marshaller\Bin\Endianness;
use Serafim\PEReader\Marshaller\MarshallerInterface;
use Serafim\PEReader\Stream\StreamInterface;

/**
 * @psalm-import-type EndiannessType from Endianness
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Type implements TypeInterface
{
    /**
     * @param positive-int|0 $bytes
     * @param EndiannessType $endianness
     */
    public function __construct(
        private int $bytes,
        #[ExpectedValues(valuesFromClass: Endianness::class)]
        private int $endianness = Endianness::ENDIAN_UNKNOWN,
    ) {
        assert($this->bytes > 0);

        if ($this->endianness === Endianness::ENDIAN_UNKNOWN) {
            $this->endianness = Endianness::current();
        }
    }

    /**
     * @param MarshallerInterface $marshaller
     * @return positive-int|0
     */
    public function bytes(MarshallerInterface $marshaller): int
    {
        return $this->bytes;
    }

    /**
     * @return EndiannessType
     */
    #[ExpectedValues(valuesFromClass: Endianness::class)]
    public function endianness(): int
    {
        return $this->endianness;
    }

    /**
     * @param StreamInterface $stream
     * @param MarshallerInterface $marshaller
     * @return mixed
     */
    public function marshal(StreamInterface $stream, MarshallerInterface $marshaller): mixed
    {
        return $stream->read($this->bytes);
    }
}
