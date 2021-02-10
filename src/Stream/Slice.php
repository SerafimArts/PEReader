<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Stream;

final class Slice implements StreamInterface
{
    /**
     * @var StreamInterface
     */
    private StreamInterface $stream;

    /**
     * @param StreamInterface $stream
     * @param positive-int|0 $size
     */
    public function __construct(StreamInterface $stream, int $size)
    {
        $this->stream = new StringStream($stream->read($size));
    }

    /**
     * @param StreamInterface $stream
     * @param positive-int|0 $size
     * @return static
     */
    public static function from(StreamInterface $stream, int $size): self
    {
        return new self($stream, $size);
    }

    /**
     * {@inheritDoc}
     */
    public function read(int $bytes): string
    {
        return $this->stream->read($bytes);
    }

    /**
     * {@inheritDoc}
     */
    public function move(int $offset): int
    {
        return $this->stream->move($offset);
    }

    /**
     * {@inheritDoc}
     */
    public function offset(): int
    {
        return $this->stream->offset();
    }
}
