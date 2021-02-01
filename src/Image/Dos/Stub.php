<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Image\Dos;

use Serafim\PEReader\Marshaller\Type\Type;

final class Stub
{
    /**
     * @var string
     */
    #[Type(bytes: 64)]
    public string $data = '';
}
