<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Stream;

class Transaction implements StreamInterface
{
    /**
     * @var int
     */
    private int $current;

    /**
     * @var StreamInterface
     */
    private StreamInterface $stream;

    /**
     * @param StreamInterface $stream
     */
    public function __construct(StreamInterface $stream)
    {
        $this->current = $stream->offset();
        $this->stream = $stream;
    }

    /**
     * @param StreamInterface $stream
     * @return static
     */
    public static function from(StreamInterface $stream): self
    {
        return new self($stream);
    }

    /**
     * @param StreamInterface $stream
     * @param \Closure(StreamInterface): mixed $then
     * @return mixed
     */
    public static function create(StreamInterface $stream, \Closure $then): mixed
    {
        $transaction = self::from($stream);
        $result = $then($transaction);
        $transaction->rollback();

        return $result;
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

    /**
     * @return void
     */
    public function commit(): void
    {
        $this->current = $this->offset();
    }

    /**
     * @return void
     */
    public function rollback(): void
    {
        $this->move($this->current);
    }

    /**
     * @return void
     */
    public function __destruct()
    {
        $this->rollback();
    }
}
