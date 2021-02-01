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
use Serafim\PEReader\Marshaller\Bin\Converter;
use Serafim\PEReader\Marshaller\Bin\Endianness;
use Serafim\PEReader\Marshaller\MarshallerInterface;
use Serafim\PEReader\Stream\StreamInterface;

/**
 * @psalm-import-type EndiannessType from Endianness
 */
#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Float64 extends Type
{
    /**
     * @param EndiannessType $endianness
     */
    public function __construct(
        #[ExpectedValues(valuesFromClass: Endianness::class)]
        int $endianness = Endianness::ENDIAN_UNKNOWN,
    ) {
        parent::__construct(8, $endianness);
    }

    /**
     * @param StreamInterface $stream
     * @param MarshallerInterface $marshaller
     * @return float
     */
    public function marshal(StreamInterface $stream, MarshallerInterface $marshaller): float
    {
        return Converter::toFloat64($stream->read($this->bytes($marshaller)), $this->endianness());
    }
}
