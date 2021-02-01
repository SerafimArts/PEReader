<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Marshaller\Bin;

use JetBrains\PhpStorm\ExpectedValues;

/**
 * @psalm-import-type EndiannessType from Endianness
 * @psalm-type Type = Converter::TYPE_*
 */
final class Converter
{
    /**
     * Signed integer (machine dependent size and byte order)
     *
     * @var string
     */
    public const TYPE_INT = 'i';

    /**
     * Unsigned integer (machine dependent size and byte order)
     *
     * @var string
     */
    public const TYPE_UINT = 'I';

    /**
     * Signed char
     *
     * @var string
     */
    public const TYPE_INT8 = 'c';

    /**
     * Unsigned char
     *
     * @var string
     */
    public const TYPE_UINT8 = 'C';

    /**
     * Signed short (always 16 bit, machine byte order)
     *
     * @var string
     */
    public const TYPE_INT16 = 's';

    /**
     * Unsigned short (always 16 bit, big endian byte order)
     *
     * @var string
     */
    public const TYPE_UINT16_BE = 'n';

    /**
     * Unsigned short (always 16 bit, little endian byte order)
     *
     * @var string
     */
    public const TYPE_UINT16_LE = 'v';

    /**
     * Unsigned short (always 16 bit, machine byte order)
     *
     * @var string
     */
    public const TYPE_UINT16_ME = 'S';

    /**
     * Signed long (always 32 bit, machine byte order)
     *
     * @var string
     */
    public const TYPE_INT32 = 'l';

    /**
     * Unsigned long (always 32 bit, big endian byte order)
     *
     * @var string
     */
    public const TYPE_UINT32_BE = 'N';

    /**
     * Unsigned long (always 32 bit, little endian byte order)
     *
     * @var string
     */
    public const TYPE_UINT32_LE = 'V';

    /**
     * Unsigned long (always 32 bit, machine byte order)
     *
     * @var string
     */
    public const TYPE_UINT32_ME = 'L';

    /**
     * Signed long long (always 64 bit, machine byte order)
     *
     * @var string
     */
    public const TYPE_INT64 = 'q';

    /**
     * Unsigned long long (always 64 bit, big endian byte order)
     *
     * @var string
     */
    public const TYPE_UINT64_BE = 'J';

    /**
     * Unsigned long long (always 64 bit, little endian byte order)
     *
     * @var string
     */
    public const TYPE_UINT64_LE = 'P';

    /**
     * Unsigned long long (always 64 bit, machine byte order)
     *
     * @var string
     */
    public const TYPE_UINT64_ME = 'Q';

    /**
     * Float (machine dependent size, big endian byte order)
     *
     * @var string
     */
    public const TYPE_FLOAT32_BE = 'G';

    /**
     * Float (machine dependent size, little endian byte order)
     *
     * @var string
     */
    public const TYPE_FLOAT32_LE = 'g';

    /**
     * Float (machine dependent size and representation)
     *
     * @var string
     */
    public const TYPE_FLOAT32_ME = 'f';

    /**
     * Double (machine dependent size, big endian byte order)
     *
     * @var string
     */
    public const TYPE_FLOAT64_BE = 'E';

    /**
     * Double (machine dependent size, little endian byte order)
     *
     * @var string
     */
    public const TYPE_FLOAT64_LE = 'e';

    /**
     * Double (machine dependent size and representation)
     *
     * @var string
     */
    public const TYPE_FLOAT64_ME = 'd';

    /**
     * @param int $value
     * @return string
     */
    public static function fromInt(int $value): string
    {
        return \pack(self::TYPE_INT, $value);
    }

    /**
     * @param string $value
     * @return int
     */
    public static function toInt(string $value): int
    {
        return (int)\unpack(self::TYPE_INT, $value)[1];
    }

    /**
     * @param int $value
     * @return string
     */
    public static function fromInt8(int $value): string
    {
        return \pack(self::TYPE_INT8, $value);
    }

    /**
     * @param string $value
     * @return int
     */
    public static function toInt8(string $value): int
    {
        return (int)\unpack(self::TYPE_INT8, $value)[1];
    }

    /**
     * @param positive-int|0 $value
     * @return string
     */
    public static function fromUInt8(int $value): string
    {
        return \pack(self::TYPE_UINT8, $value);
    }

    /**
     * @param string $value
     * @return positive-int|0
     */
    public static function toUInt8(string $value): int
    {
        return (int)\unpack(self::TYPE_UINT8, $value)[1];
    }

    /**
     * @param int $value
     * @return string
     */
    public static function fromInt16(int $value): string
    {
        return \pack(self::TYPE_INT16, $value);
    }

    /**
     * @param string $value
     * @return int
     */
    public static function toInt16(string $value): int
    {
        return (int)\unpack(self::TYPE_INT16, $value)[1];
    }

    /**
     * @param positive-int|0 $value
     * @param EndiannessType $endianness
     * @return string
     */
    public static function fromUInt16(
        int $value,
        #[ExpectedValues(valuesFromClass: Endianness::class)]
        int $endianness = Endianness::ENDIAN_UNKNOWN
    ): string {
        $format = match (self::endianness($endianness)) {
            Endianness::ENDIAN_BIG => self::TYPE_UINT16_BE,
            Endianness::ENDIAN_LITTLE => self::TYPE_UINT16_LE,
            Endianness::ENDIAN_BIG_WORD => self::TYPE_UINT16_ME,
            default => throw new \InvalidArgumentException('Unsupported endianness type')
        };

        return \pack($format, $value);
    }

    /**
     * @param string $value
     * @param EndiannessType $endianness
     * @return positive-int|0
     */
    public static function toUInt16(
        string $value,
        #[ExpectedValues(valuesFromClass: Endianness::class)]
        int $endianness = Endianness::ENDIAN_UNKNOWN
    ): int {
        $format = match (self::endianness($endianness)) {
            Endianness::ENDIAN_BIG => self::TYPE_UINT16_BE,
            Endianness::ENDIAN_LITTLE => self::TYPE_UINT16_LE,
            Endianness::ENDIAN_BIG_WORD => self::TYPE_UINT16_ME,
            default => throw new \InvalidArgumentException('Unsupported endianness type')
        };

        return (int)\unpack($format, $value)[1];
    }

    /**
     * @param int $value
     * @return string
     */
    public static function fromInt32(int $value): string
    {
        return \pack(self::TYPE_INT32, $value);
    }

    /**
     * @param string $value
     * @return int
     */
    public static function toInt32(string $value): int
    {
        return (int)\unpack(self::TYPE_INT32, $value)[1];
    }

    /**
     * @param positive-int|0 $value
     * @param EndiannessType $endianness
     * @return string
     */
    public static function fromUInt32(
        int $value,
        #[ExpectedValues(valuesFromClass: Endianness::class)]
        int $endianness = Endianness::ENDIAN_UNKNOWN
    ): string {
        $format = match (self::endianness($endianness)) {
            Endianness::ENDIAN_BIG => self::TYPE_UINT32_BE,
            Endianness::ENDIAN_LITTLE => self::TYPE_UINT32_LE,
            Endianness::ENDIAN_BIG_WORD => self::TYPE_UINT32_ME,
            default => throw new \InvalidArgumentException('Unsupported endianness type')
        };

        return \pack($format, $value);
    }

    /**
     * @param string $value
     * @param EndiannessType $endianness
     * @return positive-int|0
     */
    public static function toUInt32(
        string $value,
        #[ExpectedValues(valuesFromClass: Endianness::class)]
        int $endianness = Endianness::ENDIAN_UNKNOWN
    ): int {
        $format = match (self::endianness($endianness)) {
            Endianness::ENDIAN_BIG => self::TYPE_UINT32_BE,
            Endianness::ENDIAN_LITTLE => self::TYPE_UINT32_LE,
            Endianness::ENDIAN_BIG_WORD => self::TYPE_UINT32_ME,
            default => throw new \InvalidArgumentException('Unsupported endianness type')
        };

        return (int)\unpack($format, $value)[1];
    }

    /**
     * @param int $value
     * @return string
     */
    public static function fromInt64(int $value): string
    {
        return \pack(self::TYPE_INT64, $value);
    }

    /**
     * @param string $value
     * @return int
     */
    public static function toInt64(string $value): int
    {
        return (int)\unpack(self::TYPE_INT64, $value)[1];
    }

    /**
     * @param positive-int|0 $value
     * @param EndiannessType $endianness
     * @return string
     */
    public static function fromUInt64(
        int $value,
        #[ExpectedValues(valuesFromClass: Endianness::class)]
        int $endianness = Endianness::ENDIAN_UNKNOWN
    ): string {
        $format = match (self::endianness($endianness)) {
            Endianness::ENDIAN_BIG => self::TYPE_UINT64_BE,
            Endianness::ENDIAN_LITTLE => self::TYPE_UINT64_LE,
            Endianness::ENDIAN_BIG_WORD => self::TYPE_UINT64_ME,
            default => throw new \InvalidArgumentException('Unsupported endianness type')
        };

        return \pack($format, $value);
    }

    /**
     * @param string $value
     * @param EndiannessType $endianness
     * @return positive-int|0
     */
    public static function toUInt64(
        string $value,
        #[ExpectedValues(valuesFromClass: Endianness::class)]
        int $endianness = Endianness::ENDIAN_UNKNOWN
    ): int {
        $format = match (self::endianness($endianness)) {
            Endianness::ENDIAN_BIG => self::TYPE_UINT64_BE,
            Endianness::ENDIAN_LITTLE => self::TYPE_UINT64_LE,
            Endianness::ENDIAN_BIG_WORD => self::TYPE_UINT64_ME,
            default => throw new \InvalidArgumentException('Unsupported endianness type')
        };

        return (int)\unpack($format, $value)[1];
    }

    /**
     * @param float $value
     * @param EndiannessType $endianness
     * @return string
     */
    public static function fromFloat32(
        float $value,
        #[ExpectedValues(valuesFromClass: Endianness::class)]
        int $endianness = Endianness::ENDIAN_UNKNOWN
    ): string {
        $format = match (self::endianness($endianness)) {
            Endianness::ENDIAN_BIG => self::TYPE_FLOAT32_BE,
            Endianness::ENDIAN_LITTLE => self::TYPE_FLOAT32_LE,
            Endianness::ENDIAN_BIG_WORD => self::TYPE_FLOAT32_ME,
            default => throw new \InvalidArgumentException('Unsupported endianness type')
        };

        return \pack($format, $value);
    }

    /**
     * @param string $value
     * @param EndiannessType $endianness
     * @return float
     */
    public static function toFloat32(
        string $value,
        #[ExpectedValues(valuesFromClass: Endianness::class)]
        int $endianness = Endianness::ENDIAN_UNKNOWN
    ): float {
        $format = match (self::endianness($endianness)) {
            Endianness::ENDIAN_BIG => self::TYPE_FLOAT32_BE,
            Endianness::ENDIAN_LITTLE => self::TYPE_FLOAT32_LE,
            Endianness::ENDIAN_BIG_WORD => self::TYPE_FLOAT32_ME,
            default => throw new \InvalidArgumentException('Unsupported endianness type')
        };

        return (float)\unpack($format, $value)[1];
    }

    /**
     * @param float $value
     * @param EndiannessType $endianness
     * @return string
     */
    public static function fromFloat64(
        float $value,
        #[ExpectedValues(valuesFromClass: Endianness::class)]
        int $endianness = Endianness::ENDIAN_UNKNOWN
    ): string {
        $format = match (self::endianness($endianness)) {
            Endianness::ENDIAN_BIG => self::TYPE_FLOAT64_BE,
            Endianness::ENDIAN_LITTLE => self::TYPE_FLOAT64_LE,
            Endianness::ENDIAN_BIG_WORD => self::TYPE_FLOAT64_ME,
            default => throw new \InvalidArgumentException('Unsupported endianness type')
        };

        return \pack($format, $value);
    }

    /**
     * @param string $value
     * @param EndiannessType $endianness
     * @return float
     */
    public static function toFloat64(
        string $value,
        #[ExpectedValues(valuesFromClass: Endianness::class)]
        int $endianness = Endianness::ENDIAN_UNKNOWN
    ): float {
        $format = match (self::endianness($endianness)) {
            Endianness::ENDIAN_BIG => self::TYPE_FLOAT64_BE,
            Endianness::ENDIAN_LITTLE => self::TYPE_FLOAT64_LE,
            Endianness::ENDIAN_BIG_WORD => self::TYPE_FLOAT64_ME,
            default => throw new \InvalidArgumentException('Unsupported endianness type')
        };

        return (float)\unpack($format, $value)[1];
    }

    /**
     * @param EndiannessType $value
     * @return EndiannessType
     */
    #[ExpectedValues(valuesFromClass: Endianness::class)]
    private static function endianness(
        #[ExpectedValues(valuesFromClass: Endianness::class)]
        int $value
    ): int {
        return $value === Endianness::ENDIAN_UNKNOWN ? Endianness::current() : $value;
    }
}
