<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Image\OptionalHeader;

use Serafim\PEReader\Marshaller\Type\Struct;

final class DataDirectories
{
    /**
     * The export table address and size (.edata).
     *
     * @see https://docs.microsoft.com/en-us/windows/win32/debug/pe-format#the-edata-section-image-only
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $export = null;

    /**
     * The import table address and size (.idata).
     *
     * @see https://docs.microsoft.com/en-us/windows/win32/debug/pe-format#the-idata-section
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $import = null;

    /**
     * The resource table address and size (.rsrc).
     *
     * @see https://docs.microsoft.com/en-us/windows/win32/debug/pe-format#the-rsrc-section
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $resource = null;

    /**
     * The exception table address and size (.pdata).
     *
     * @see https://docs.microsoft.com/en-us/windows/win32/debug/pe-format#the-pdata-section
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $exception = null;

    /**
     * The attribute certificate table address and size.
     *
     * @see https://docs.microsoft.com/en-us/windows/win32/debug/pe-format#the-attribute-certificate-table-image-only
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $security = null;

    /**
     * The base relocation table address and size (.reloc).
     *
     * @see https://docs.microsoft.com/en-us/windows/win32/debug/pe-format#the-reloc-section-image-only
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $baseRelocationTable = null;

    /**
     * The debug data starting address and size (.debug).
     *
     * @see https://docs.microsoft.com/en-us/windows/win32/debug/pe-format#the-debug-section
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $debugDirectory = null;

    /**
     * Reserved, must be empty.
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $copyrightOrArchitectureSpecificData = null;

    /**
     * The RVA of the value to be stored in the global pointer register.
     * The size member of this structure must be set to 0.
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $globalPtr = null;

    /**
     * The thread local storage (TLS) table address and size (.tls).
     *
     * @see https://docs.microsoft.com/en-us/windows/win32/debug/pe-format#the-tls-section
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $tlsDirectory = null;

    /**
     * The load configuration table address and size.
     *
     * @see https://docs.microsoft.com/en-us/windows/win32/debug/pe-format#the-load-configuration-structure-image-only
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $loadConfigurationDirectory = null;

    /**
     * The bound import table address and size.
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $boundImportDirectory = null;

    /**
     * The import address table address and size.
     *
     * @see https://docs.microsoft.com/en-us/windows/win32/debug/pe-format#import-address-table
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $importAddressTable = null;

    /**
     * The delay import descriptor address and size.
     *
     * @see https://docs.microsoft.com/en-us/windows/win32/debug/pe-format#delay-load-import-tables-image-only
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $delayLoadImportDescriptors = null;

    /**
     * The CLR runtime header address and size (.cormeta).
     *
     * @see https://docs.microsoft.com/en-us/windows/win32/debug/pe-format#the-cormeta-section-object-only
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $comRuntimeDescriptor = null;

    /**
     * Reserved, must be empty.
     *
     * @var DataDirectory|null
     */
    #[Struct(of: DataDirectory::class)]
    public ?DataDirectory $reserved = null;
}
