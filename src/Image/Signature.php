<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Image;

/**
 * @psalm-type SignatureType = Signature::IMAGE_*
 */
final class Signature
{
    /**
     * @var int
     */
    public const IMAGE_DOS_SIGNATURE = 0x5A4D;

    /**
     * @var int
     */
    public const IMAGE_OS2_SIGNATURE = 0x454E;

    /**
     * @var int
     */
    public const IMAGE_OS2_SIGNATURE_LE = 0x454C;

    /**
     * @var int
     */
    public const IMAGE_NT_SIGNATURE = 0x00004550;
}
