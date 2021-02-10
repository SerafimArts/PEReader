<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Image\Coff;

use JetBrains\PhpStorm\ExpectedValues;
use Serafim\PEReader\Marshaller\Bin\Endianness;
use Serafim\PEReader\Marshaller\Type\Timestamp;
use Serafim\PEReader\Marshaller\Type\UInt16;
use Serafim\PEReader\Marshaller\Type\UInt32;

/**
 * @psalm-import-type MachineType from Machine
 */
final class FileHeader
{
    /**
     * @var MachineType
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE), ExpectedValues(valuesFromClass: Machine::class)]
    public int $machine = 0;

    /**
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $numberOfSections = 0;

    /**
     * @var \DateTimeInterface
     */
    #[Timestamp(endianness: Endianness::ENDIAN_LITTLE)]
    public \DateTimeInterface $timestamp;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $pointerToSymbolTable = 0;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $numberOfSymbols = 0;

    /**
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $sizeOfOptionalHeader = 0;

    /**
     * TODO BIT mapping to Characteristics (1 bit per field)
     *
     * @see Characteristics
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $characteristics = 0;

    /**
     * FileHeader constructor.
     */
    public function __construct()
    {
        $this->timestamp = (new \DateTimeImmutable())->setTimestamp(0);
    }
}
