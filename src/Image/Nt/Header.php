<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Image\Nt;

use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;
use Serafim\PEReader\Image\FileHeader;
use Serafim\PEReader\Image\Signature;
use Serafim\PEReader\Marshaller\Bin\Endianness;
use Serafim\PEReader\Marshaller\Type\Struct;
use Serafim\PEReader\Marshaller\Type\UInt32;

/**
 * @psalm-import-type SignatureType from Signature
 */
final class Header
{
    /**
     * The file can be identified by the ASCII string "MZ" (hexadecimal: 4D 5A)
     * at the beginning of the file (the "magic number").
     *
     * @var SignatureType
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE), ExpectedValues(valuesFromClass: Signature::class)]
    public int $signature = Signature::IMAGE_NT_SIGNATURE;

    /**
     * @var FileHeader
     */
    #[Struct(of: FileHeader::class)]
    public FileHeader $fileHeader;

    /**
     * Header constructor.
     */
    public function __construct()
    {
        $this->fileHeader = new FileHeader();
    }
}
