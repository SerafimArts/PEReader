<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Marshaller\Type;

use Serafim\PEReader\Marshaller\Bin\Converter;
use Serafim\PEReader\Marshaller\MarshallerInterface;
use Serafim\PEReader\Stream\StreamInterface;

#[\Attribute(\Attribute::TARGET_PROPERTY)]
class Int16 extends Type
{
    /**
     * Int16 constructor.
     */
    public function __construct()
    {
        parent::__construct(2);
    }

    /**
     * @param StreamInterface $stream
     * @param MarshallerInterface $marshaller
     * @return int
     */
    public function marshal(StreamInterface $stream, MarshallerInterface $marshaller): int
    {
        return Converter::toInt16($stream->read($this->bytes($marshaller)));
    }
}
