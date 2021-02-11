<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Image;

use Serafim\PEReader\Marshaller\Bin\Endianness;
use Serafim\PEReader\Marshaller\Type\AnsiString;
use Serafim\PEReader\Marshaller\Type\UInt16;
use Serafim\PEReader\Marshaller\Type\UInt32;
use Serafim\PEReader\Stream\Slice;
use Serafim\PEReader\Stream\StreamInterface;
use Serafim\PEReader\Stream\StringStream;

final class SectionHeader
{
    /**
     * @var string
     */
    #[AnsiString(length: 8)]
    public string $name = '';

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $misc = 0;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $virtualAddress = 0;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $sizeOfRawData = 0;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $pointerToRawData = 0;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $pointerToRelocations = 0;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $pointerToLineNumbers = 0;

    /**
     * @var positive-int|0
     */
    #[UInt16]
    public int $numberOfRelocations = 0;

    /**
     * @var positive-int|0
     */
    #[UInt16]
    public int $numberOfLineNumbers = 0;

    /**
     * TODO BIT mapping to Section Characteristics (1 bit per field)
     *
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $characteristics = 0;

    /**
     * @var StreamInterface|null
     */
    private ?StreamInterface $stream = null;

    /**
     * @param StreamInterface $stream
     * @return $this
     */
    public function withStream(StreamInterface $stream): self
    {
        $self = clone $this;
        $self->stream = $stream;

        return $self;
    }

    /**
     * @return StreamInterface
     */
    public function read(): StreamInterface
    {
        if ($this->stream === null) {
            return StringStream::empty();
        }

        $this->stream->move($this->pointerToRawData);

        return new Slice($this->stream, $this->sizeOfRawData);
    }

    /**
     * @param int $virtualAddress
     * @return bool
     */
    public function contains(int $virtualAddress): bool
    {
        return $virtualAddress >= $this->virtualAddress &&
            $virtualAddress <= $this->virtualAddress + $this->sizeOfRawData;
    }

    /**
     * @param int $virtualAddress
     * @return int
     */
    public function toPhysical(int $virtualAddress): int
    {
        return $this->pointerToRawData + $virtualAddress - $this->virtualAddress;
    }
}
