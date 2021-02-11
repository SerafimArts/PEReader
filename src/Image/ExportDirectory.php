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
use Serafim\PEReader\Marshaller\Type\Timestamp;
use Serafim\PEReader\Marshaller\Type\UInt16;
use Serafim\PEReader\Marshaller\Type\UInt32;

class ExportDirectory
{
    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $characteristics = 0;

    /**
     * @var \DateTimeInterface
     */
    #[Timestamp(endianness: Endianness::ENDIAN_LITTLE)]
    public \DateTimeInterface $timeDateStamp;

    /**
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $majorVersion = 0;

    /**
     * @var positive-int|0
     */
    #[UInt16(endianness: Endianness::ENDIAN_LITTLE)]
    public int $minorVersion = 0;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $name = 0;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $base = 0;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $numberOfFunctions = 0;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $numberOfNames = 0;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $addressOfFunctions = 0;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $addressOfNames = 0;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $addressOfNameOrdinals = 0;

    /**
     * @var array<string>
     */
    public array $functions = [];

    /**
     * ExportDirectory constructor.
     */
    public function __construct()
    {
        $this->timeDateStamp = new \DateTimeImmutable();
    }
}
