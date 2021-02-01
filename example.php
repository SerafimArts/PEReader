<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use Serafim\PEReader\Reader;
use Serafim\PEReader\Stream\FileStream;

require __DIR__ . '/vendor/autoload.php';

// Copy test file
$file = __DIR__ . '/resources/php.exe';
\is_file($file) || \copy(\PHP_BINARY, $file);

$reader = new Reader();

// Read
foreach ($reader->read(new FileStream($file)) as $struct) {
    dump($struct);
}
