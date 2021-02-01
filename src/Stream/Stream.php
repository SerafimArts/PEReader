<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Stream;

abstract class Stream implements StreamInterface
{
    /**
     * @var resource
     */
    private $stream;

    /**
     * @param string $file
     */
    protected function openFile(string $file): void
    {
        if (! \is_file($file) || ! \is_readable($file)) {
            throw new \LogicException('Could not open file "' . $file . '" for reading');
        }

        $this->openSource($file);
    }

    /**
     * @param string $source
     */
    protected function openSource(string $source): void
    {
        $this->openStream(\fopen($source, 'rb+'));
    }

    /**
     * @param resource $resource
     */
    protected function openStream($resource): void
    {
        if (! @\rewind($resource)) {
            throw new \LogicException('Could not rewind stream #' . \get_resource_id($resource));
        }

        $this->stream = $resource;
    }

    /**
     * @param positive-int $bytes
     * @return string
     */
    public function read(int $bytes): string
    {
        assert($bytes > 0);

        return \fread($this->stream, $bytes);
    }

    /**
     * @param int $offset
     */
    public function move(int $offset): int
    {
        return \fseek($this->stream, $offset);
    }

    /**
     * {@inheritDoc}
     */
    public function offset(): int
    {
        return (int)\ftell($this->stream);
    }
}
