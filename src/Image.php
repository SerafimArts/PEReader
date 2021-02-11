<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader;

use Serafim\PEReader\Image\CoffHeader as NtHeader;
use Serafim\PEReader\Image\DosHeader as DosHeader;
use Serafim\PEReader\Image\ExportDirectory;
use Serafim\PEReader\Image\SectionHeader;
use Serafim\PEReader\Image\SectionHeaders;

final class Image
{
    /**
     * @var DosHeader
     */
    public DosHeader $dos;

    /**
     * @var NtHeader
     */
    public NtHeader $coff;

    /**
     * @var SectionHeaders
     */
    public SectionHeaders $sections;

    /**
     * @var ExportDirectory|null
     */
    public ?ExportDirectory $exportDirectory = null;

    /**
     * Image constructor.
     */
    public function __construct()
    {
        $this->dos = new DosHeader();
        $this->coff = new NtHeader();
        $this->sections = new SectionHeaders();
    }
}
