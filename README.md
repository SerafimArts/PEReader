# PE/COFF Reader

> Note: WIP

See: https://en.wikipedia.org/wiki/Portable_Executable

TL;DR: This means that this implementation reads data from the following files:

- `*.exe`
- `*.dll`
- `*.ocx`
- `*.sys`
- `*.scr`
- `*.drv`
- `*.cpl`
- `*.efi`

## Example

Reading example:

```php
<?php

use Serafim\PEReader\Reader;
use Serafim\PEReader\Stream\FileStream;

$reader = new Reader();

dump($reader->read(new FileStream('../path/to/file.exe')));
```

An example output of `php.exe` (PHP 8.0.1 x64 NTS):

```
Serafim\PEReader\Image {#20
  +dos: Serafim\PEReader\Image\DosHeader {#29
    +signature: 23117
    +usedBytesInTheLastPage: 144
    +fileSizeInPages: 3
    +numberOfRelocationItems: 0
    +headerSizeInParagraphs: 4
    +minimumExtraParagraphs: 0
    +maximumExtraParagraphs: 65535
    +initialRelativeSS: 0
    +initialSP: 184
    +checksum: 0
    +initialIP: 0
    +initialRelativeCS: 0
    +addressOfRelocationTable: 64
    +overlayNumber: 0
    -reserved: array:4 [
      0 => 0
      1 => 0
      2 => 0
      3 => 0
    ]
    +oemIdentifier: 0
    +oemInfo: 0
    -reserved2: array:10 [
      0 => 0
      1 => 0
      2 => 0
      3 => 0
      4 => 0
      5 => 0
      6 => 0
      7 => 0
      8 => 0
      9 => 0
    ]
    +addressOfNewExeHeader: 272
  }
  +coff: Serafim\PEReader\Image\CoffHeader {#52
    +signature: 17744
    +fileHeader: Serafim\PEReader\Image\Coff\FileHeader {#48
      +machine: 34404
      +numberOfSections: 6
      +timestamp: DateTimeImmutable @1611147557 {#57
        date: 2021-01-20 12:59:17.0 UTC (+00:00)
      }
      +pointerToSymbolTable: 0
      +numberOfSymbols: 0
      +sizeOfOptionalHeader: 240
      +characteristics: 34
    }
    +optionalHeader: Serafim\PEReader\Image\OptionalHeader\OptionalHeader64 {#40
      +magic: 523
      +majorLinkerVersion: 14
      +minorLinkerVersion: 28
      +sizeOfCode: 48128
      +sizeOfInitializedData: 90624
      +sizeOfUninitializedData: 0
      +addressOfEntryPoint: 49360
      +baseOfCode: 4096
      +imageBase: 5368709120
      +sectionAlignment: 4096
      +fileAlignment: 512
      +majorOperatingSystemVersion: 6
      +minorOperatingSystemVersion: 0
      +majorImageVersion: 0
      +minorImageVersion: 0
      +majorSubsystemVersion: 6
      +minorSubsystemVersion: 0
      +win32VersionValue: 0
      +sizeOfImage: 163840
      +sizeOfHeaders: 1024
      +checkSum: 163994
      +subsystem: 3
      +dllCharacteristics: 49504
      +sizeOfStackReserve: 67108864
      +sizeOfStackCommit: 4096
      +sizeOfHeapReserve: 1048576
      +sizeOfHeapCommit: 4096
      +loaderFlags: 0
      +numberOfRvaAndSizes: 16
      +dataDirectories: Serafim\PEReader\Image\OptionalHeader\DataDirectories {#32
        +export: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#38
          +virtualAddress: 121936
          +size: 144
        }
        +import: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#34
          +virtualAddress: 122080
          +size: 320
        }
        +resource: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#51
          +virtualAddress: 147456
          +size: 4356
        }
        +exception: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#36
          +virtualAddress: 143360
          +size: 1956
        }
        +security: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#78
          +virtualAddress: 0
          +size: 0
        }
        +baseRelocationTable: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#77
          +virtualAddress: 155648
          +size: 5160
        }
        +debugDirectory: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#76
          +virtualAddress: 118316
          +size: 84
        }
        +copyrightOrArchitectureSpecificData: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#80
          +virtualAddress: 0
          +size: 0
        }
        +globalPtr: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#81
          +virtualAddress: 0
          +size: 0
        }
        +tlsDirectory: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#79
          +virtualAddress: 0
          +size: 0
        }
        +loadConfigurationDirectory: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#75
          +virtualAddress: 118400
          +size: 312
        }
        +boundImportDirectory: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#45
          +virtualAddress: 0
          +size: 0
        }
        +importAddressTable: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#35
          +virtualAddress: 53248
          +size: 2200
        }
        +delayLoadImportDescriptors: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#46
          +virtualAddress: 0
          +size: 0
        }
        +comRuntimeDescriptor: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#44
          +virtualAddress: 0
          +size: 0
        }
        +reserved: Serafim\PEReader\Image\OptionalHeader\DataDirectory {#73
          +virtualAddress: 0
          +size: 0
        }
      }
    }
  }
  +sections: Serafim\PEReader\Image\SectionHeaders {#27
    -headers: array:6 [
      0 => Serafim\PEReader\Image\SectionHeader {#24
        +name: ".text"
        +misc: 47788
        +virtualAddress: 4096
        +sizeOfRawData: 48128
        +pointerToRawData: 1024
        +pointerToRelocations: 0
        +pointerToLineNumbers: 0
        +numberOfRelocations: 0
        +numberOfLineNumbers: 0
        +characteristics: 1610612768
      }
      1 => Serafim\PEReader\Image\SectionHeader {#63
        +name: ".rdata"
        +misc: 76800
        +virtualAddress: 53248
        +sizeOfRawData: 76800
        +pointerToRawData: 49152
        +pointerToRelocations: 0
        +pointerToLineNumbers: 0
        +numberOfRelocations: 0
        +numberOfLineNumbers: 0
        +characteristics: 1073741888
      }
      2 => Serafim\PEReader\Image\SectionHeader {#82
        +name: ".data"
        +misc: 11480
        +virtualAddress: 131072
        +sizeOfRawData: 1536
        +pointerToRawData: 125952
        +pointerToRelocations: 0
        +pointerToLineNumbers: 0
        +numberOfRelocations: 0
        +numberOfLineNumbers: 0
        +characteristics: 3221225536
      }
      3 => Serafim\PEReader\Image\SectionHeader {#42
        +name: ".pdata"
        +misc: 1956
        +virtualAddress: 143360
        +sizeOfRawData: 2048
        +pointerToRawData: 127488
        +pointerToRelocations: 0
        +pointerToLineNumbers: 0
        +numberOfRelocations: 0
        +numberOfLineNumbers: 0
        +characteristics: 1073741888
      }
      4 => Serafim\PEReader\Image\SectionHeader {#23
        +name: ".rsrc"
        +misc: 4356
        +virtualAddress: 147456
        +sizeOfRawData: 4608
        +pointerToRawData: 129536
        +pointerToRelocations: 0
        +pointerToLineNumbers: 0
        +numberOfRelocations: 0
        +numberOfLineNumbers: 0
        +characteristics: 1073741888
      }
      5 => Serafim\PEReader\Image\SectionHeader {#56
        +name: ".reloc"
        +misc: 5160
        +virtualAddress: 155648
        +sizeOfRawData: 5632
        +pointerToRawData: 134144
        +pointerToRelocations: 0
        +pointerToLineNumbers: 0
        +numberOfRelocations: 0
        +numberOfLineNumbers: 0
        +characteristics: 1107296320
      }
    ]
  }
  +exportDirectory: Serafim\PEReader\Image\ExportDirectory {#93
    +characteristics: 0
    +timeDateStamp: DateTimeImmutable @4294967295 {#58
      date: 2106-02-07 06:28:15.0 UTC (+00:00)
    }
    +majorVersion: 0
    +minorVersion: 0
    +name: 122006
    +base: 1
    +numberOfFunctions: 3
    +numberOfNames: 3
    +addressOfFunctions: 121976
    +addressOfNames: 121988
    +addressOfNameOrdinals: 122000
    +functions: array:3 [
      0 => "OPENSSL_Applink"
      1 => "php_cli_get_shell_callbacks"
      2 => "sapi_cli_single_write"
    ]
  }
}
```

## Why?

Why not?
