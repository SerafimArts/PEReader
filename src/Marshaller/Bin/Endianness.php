<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Marshaller\Bin;

use Serafim\PEReader\Marshaller\Support\ForeignFunctionInterface;

/**
 * Endianness is the order of the bytes in multi-byte data types, such as int
 * or float. It may vary from processor to processor, and even from operating
 * system to operating system. Detecting the correct endianness is difficult
 * for several reasons:
 *
 *  - Big Endianness:
 *          Some processors support multiple endian modes, even to the extent
 *          of allowing dynamically changing between big and little-endian.
 *
 *  - Middle Endianness:
 *          The two most common types of endianness are byte-swapped big-endian
 *          (ABCD) and byte-swapped little-endian (DCBA), but some older
 *          processors use other types. For instance, PDP-11 used word-swapped
 *          little-endian (BADC), and Honeywell 316 used word-swapped
 *          big-endian (CDAB).
 *
 *  - Integer vs Floating Point:
 *          Some processors use a different endian model for integers versus
 *          floating-point values.
 *
 *  - Processor vs Operating System:
 *          Most operating systems follow the endianness of the underlying
 *          hardware, but some (e.g. VOS) retain their historic big-endian
 *          environment even when ported to little-endian processors.
 *
 * @psalm-type EndiannessType = Endianness::ENDIAN_*
 *
 * @see https://sourceforge.net/p/predef/wiki/Endianness/
 */
final class Endianness
{
    /**
     * @var int
     */
    public const ENDIAN_UNKNOWN = 0x00;

    /**
     * @see https://en.wikipedia.org/wiki/Endianness#Bi-endian_hardware
     * @var int
     */
    public const ENDIAN_BIG = 0x01;

    /**
     * @var int
     */
    public const ENDIAN_LITTLE = 0x02;

    /**
     * Middle-endian, Honeywell 316 style.
     *
     * @see https://en.wikipedia.org/wiki/Endianness#Middle-endian
     * @see https://en.wikipedia.org/wiki/Honeywell_316
     *
     * @var int
     */
    public const ENDIAN_BIG_WORD = 0x03;

    /**
     * Middle-endian, PDP-11 style.
     *
     * @see https://en.wikipedia.org/wiki/Endianness#Middle-endian
     * @see https://en.wikipedia.org/wiki/PDP-11
     *
     * @var int
     */
    public const ENDIAN_LITTLE_WORD = 0x04;

    /**
     * @psalm-var EndiannessType|null
     * @var int|null
     */
    private static ?int $current = null;

    /**
     * Returns current byte order type used by the operating system and memoize
     * determination result.
     *
     * @psalm-return EndiannessType
     * @return int
     */
    public static function current(): int
    {
        return self::$current ??= self::detect();
    }

    /**
     * Returns current byte order type used by the operating system.
     *
     * @psalm-return EndiannessType
     * @return int
     */
    private static function detect(): int
    {
        if (\unpack('S', "\x01\x00")[1] === 1) {
            return self::ENDIAN_LITTLE;
        }

        return self::ENDIAN_BIG;
    }

    /**
     * @return bool
     */
    public static function isLittleEndian(): bool
    {
        return self::current() === self::ENDIAN_LITTLE;
    }

    /**
     * @return bool
     */
    public static function isBigEndian(): bool
    {
        return self::current() === self::ENDIAN_BIG;
    }

    /**
     * @return bool
     */
    public static function isMiddleEndian(): bool
    {
        return \in_array(self::current(), [self::ENDIAN_LITTLE_WORD, self::ENDIAN_BIG_WORD], true);
    }
}
