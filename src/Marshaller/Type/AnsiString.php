<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Marshaller\Type;

use Serafim\PEReader\Marshaller\MarshallerInterface;
use Serafim\PEReader\Stream\StreamInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class AnsiString extends Type
{
    /**
     * @param positive-int|0 $length
     */
    public function __construct(int $length = 0)
    {
        assert($length >= 0);

        parent::__construct($length);
    }

    /**
     * @param StreamInterface $stream
     * @param MarshallerInterface $marshaller
     * @return string
     */
    public function marshal(StreamInterface $stream, MarshallerInterface $marshaller): string
    {
        return \rtrim($stream->read($this->bytes($marshaller)), "\x00");
    }
}
