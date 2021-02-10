<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Stream;

final class Lookahead
{
    /**
     * @param StreamInterface $stream
     * @param positive-int $bytes
     * @return string
     */
    public static function read(StreamInterface $stream, int $bytes): string
    {
        assert($bytes > 0);

        $transaction = Transaction::from($stream);

        try {
            return $transaction->read($bytes);
        } finally {
            $transaction->rollback();
        }
    }
}
