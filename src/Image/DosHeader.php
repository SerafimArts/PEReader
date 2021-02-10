<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Image;

use JetBrains\PhpStorm\ExpectedValues;
use Serafim\PEReader\Marshaller\Bin\Endianness;
use Serafim\PEReader\Marshaller\Type\ArrayType;
use Serafim\PEReader\Marshaller\Type\Int32;
use Serafim\PEReader\Marshaller\Type\UInt16;

/**
 * @psalm-import-type SignatureType from Signature
 */
final class DosHeader
{
    /**
     * The file can be identified by the ASCII string "MZ" (hexadecimal: 4D 5A)
     * at the beginning of the file (the "magic number").
     *
     * @var SignatureType
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE), ExpectedValues(valuesFromClass: Signature::class)]
    public int $signature = Signature::IMAGE_DOS_SIGNATURE;

    /**
     * Bytes on last page of file
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $usedBytesInTheLastPage = 0;

    /**
     * Pages in file
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $fileSizeInPages = 0;

    /**
     * Relocations
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $numberOfRelocationItems = 0;

    /**
     * Size of header in paragraphs
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $headerSizeInParagraphs = 0;

    /**
     * Minimum extra paragraphs needed
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $minimumExtraParagraphs = 0;

    /**
     * Maximum extra paragraphs needed
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $maximumExtraParagraphs = 0;

    /**
     * Initial (relative) SS value
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $initialRelativeSS = 0;

    /**
     * Initial SP value
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $initialSP = 0;

    /**
     * Checksum
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $checksum = 0;

    /**
     * Initial IP value
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $initialIP = 0;

    /**
     * Initial (relative) CS value
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $initialRelativeCS = 0;

    /**
     * File address of relocation table
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $addressOfRelocationTable = 0;

    /**
     * Overlay number
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $overlayNumber = 0;

    /**
     * Reserved words
     *
     * @var array<positive-int|0>
     */
    #[ArrayType(size: 4, of: UInt16::class, args: ['endianness' => Endianness::ENDIAN_LITTLE])]
    private array $reserved = [0, 0, 0, 0];

    /**
     * OEM identifier (for {@see DosHeader::$oemInfo})
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $oemIdentifier = 0;

    /**
     * OEM information
     *
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $oemInfo = 0;

    /**
     * Reserved words
     *
     * @var array<positive-int|0>
     */
    #[ArrayType(size: 10, of: UInt16::class, args: ['endianness' => Endianness::ENDIAN_LITTLE])]
    private array $reserved2 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

    /**
     * NtHeader Offset
     *
     * @var int
     */
    #[Int32]
    public int $addressOfNewExeHeader = 0;
}
