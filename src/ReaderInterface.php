<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader;

use Serafim\PEReader\Stream\StreamInterface;

interface ReaderInterface
{
    /**
     * @param StreamInterface $stream
     * @return Image
     */
    public function read(StreamInterface $stream): Image;
}
