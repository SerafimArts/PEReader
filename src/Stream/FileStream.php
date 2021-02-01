<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Stream;

final class FileStream extends Stream
{
    /**
     * @param string $file
     */
    public function __construct(string $file)
    {
        $this->openFile($file);
    }
}
