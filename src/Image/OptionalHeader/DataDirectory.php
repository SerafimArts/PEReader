<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Image\OptionalHeader;

use Serafim\PEReader\Marshaller\Bin\Endianness;
use Serafim\PEReader\Marshaller\Type\UInt32;

/**
 * Each data directory gives the address and size of a table or string that
 * Windows uses. These data directory entries are all loaded into memory so
 * that the system can use them at run time. A data directory is an 8-byte
 * field that has the following declaration:
 *
 * <code>
 *  typedef struct _IMAGE_DATA_DIRECTORY {
 *      DWORD   VirtualAddress;
 *      DWORD   Size;
 *  }
 *      IMAGE_DATA_DIRECTORY,
 *      * PIMAGE_DATA_DIRECTORY
 *  ;
 * </code>
 */
final class DataDirectory
{
    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $virtualAddress = 0;

    /**
     * @var positive-int|0
     */
    #[UInt32(endianness: Endianness::ENDIAN_LITTLE)]
    public int $size = 0;
}
