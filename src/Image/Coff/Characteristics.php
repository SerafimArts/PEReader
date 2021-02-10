<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Image\Coff;

final class Characteristics
{
    /**
     * 0x0001  Relocation info stripped from file
     *
     * @var positive-int|0
     */
    public int $imageFileRelocationsStripped = 0;

    /**
     * 0x0002  File is executable
     *
     * @var positive-int|0
     */
    public int $imageFileExecutableImage = 0;

    /**
     * 0x0004  Line numbers stripped from file
     *
     * @var positive-int|0
     */
    public int $imageFileLineNumsStripped = 0;

    /**
     * 0x0008  Local symbols stripped from file
     *
     * @var positive-int|0
     */
    public int $imageFileLocalSymbolsStripped = 0;

    /**
     * 0x0010  Aggressively trim working set
     *
     * @var positive-int|0
     */
    public int $imageFileAggressiveWsTrim = 0;

    /**
     * 0x0020  App can handle >2gb addresses
     *
     * @var positive-int|0
     */
    public int $imageFileLargeAddressAware = 0;

    /**
     * 0x0040  Reserved
     *
     * @var positive-int|0
     */
    public int $reserved = 0;

    /**
     * 0x0080  Bytes of machine word are reversed
     *
     * @var positive-int|0
     */
    public int $imageFileBytesReversedLo = 0;

    /**
     * 0x0100  32 bit word machine
     *
     * @var positive-int|0
     */
    public int $imageFile32BitMachine = 0;

    /**
     * 0x0200  Debugging info stripped from file in .DBG file
     *
     * @var positive-int|0
     */
    public int $imageFileDebugStripped = 0;

    /**
     * 0x0400  If Image is on removable media, copy and run from the swap file
     *
     * @var positive-int|0
     */
    public int $imageFileRemovableRunFromSwap = 0;

    /**
     * 0x0800  If Image is on Net, copy and run from the swap file
     *
     * @var positive-int|0
     */
    public int $imageFileNetRunFromSwap = 0;

    /**
     * 0x1000  System File
     *
     * @var positive-int|0
     */
    public int $imageFileSystem = 0;

    /**
     * 0x2000  File is a DLL
     *
     * @var positive-int|0
     */
    public int $imageFileDll = 0;

    /**
     * 0x4000  File should only be run on a UP machine
     *
     * @var positive-int|0
     */
    public int $imageFileUpSystemOnly = 0;

    /**
     * 0x8000  Bytes of machine word are reversed
     *
     * @var positive-int|0
     */
    public int $imageFileBytesReversedHi = 0;
}
