<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Stream;

final class StringStream extends Stream
{
    /**
     * @param string $data
     */
    public function __construct(string $data)
    {
        $stream = \fopen('php://memory', 'ab+');

        \fwrite($stream, $data);

        $this->openStream($stream);
    }

    /**
     * @return static
     */
    public static function empty(): self
    {
        return new self('');
    }
}
