<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Image\OptionalHeader;

/**
 * @psalm-type SignatureType = OptionalHeaderSignature::*
 */
final class OptionalHeaderSignature
{
    /**
     * @var int
     */
    public const PE32 = 0x10b;

    /**
     * @var int
     */
    public const PE64 = 0x20b;

    /**
     * @var int
     */
    public const ROM  = 0x10;
}
