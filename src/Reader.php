<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader;

use Doctrine\Instantiator\Exception\ExceptionInterface;
use Doctrine\Instantiator\InstantiatorInterface;
use JetBrains\PhpStorm\NoReturn;
use Serafim\PEReader\Image\Coff\FileHeader;
use Serafim\PEReader\Image\CoffHeader;
use Serafim\PEReader\Image\DosHeader;
use Serafim\PEReader\Image\ExportDirectory;
use Serafim\PEReader\Image\OptionalHeader\DataDirectories;
use Serafim\PEReader\Image\OptionalHeader\OptionalHeader32;
use Serafim\PEReader\Image\OptionalHeader\OptionalHeader64;
use Serafim\PEReader\Image\OptionalHeader\OptionalHeaderSignature;
use Serafim\PEReader\Image\SectionHeader;
use Serafim\PEReader\Image\SectionHeaders;
use Serafim\PEReader\Image\Signature;
use Serafim\PEReader\Marshaller\Bin\Converter;
use Serafim\PEReader\Marshaller\Bin\Endianness;
use Serafim\PEReader\Marshaller\Marshaller;
use Serafim\PEReader\Marshaller\MarshallerInterface;
use Serafim\PEReader\Marshaller\Type\UInt32;
use Serafim\PEReader\Stream\Lookahead;
use Serafim\PEReader\Stream\Slice;
use Serafim\PEReader\Stream\StreamInterface;
use Spiral\Attributes\ReaderInterface as AttributesReaderInterface;

final class Reader implements ReaderInterface
{
    /**
     * @var MarshallerInterface
     */
    private MarshallerInterface $marshaller;

    /**
     * @param AttributesReaderInterface|null $reader
     * @param InstantiatorInterface|null $instantiator
     */
    public function __construct(AttributesReaderInterface $reader = null, InstantiatorInterface $instantiator = null)
    {
        $this->marshaller = new Marshaller($reader, $instantiator);
    }

    /**
     * @param string $message
     * @param mixed ...$args
     */
    #[NoReturn]
    private function error(string $message, ...$args): void
    {
        throw new \LogicException(\vsprintf($message, $args));
    }

    /**
     * {@inheritDoc}
     * @throws \Throwable
     */
    public function read(StreamInterface $stream): Image
    {
        $image = new Image();

        // Read MS DOS header
        $image->dos = $this->readDosHeader($stream);

        // Move to NT header
        $stream->move($image->dos->addressOfNewExeHeader);

        // Read NT header
        $image->coff = $this->readCoffHeader($stream);

        // Read Section headers
        for ($i = 0; $i <= $image->coff->fileHeader->numberOfSections; ++$i) {
            $header = $this->marshaller->marshal(SectionHeader::class, $stream);

            $image->sections->add($header->withStream($stream));
        }

        // Read EAT
        $image->exportDirectory = $this->readEat($image->coff, $image->sections, $stream);

        return $image;
    }

    /**
     * @param CoffHeader $coff
     * @param SectionHeaders $sections
     * @param StreamInterface $stream
     * @return ExportDirectory|null
     * @throws ExceptionInterface
     */
    private function readEat(CoffHeader $coff, SectionHeaders $sections, StreamInterface $stream): ?ExportDirectory
    {
        $export = $coff->optionalHeader->dataDirectories->export;

        if ($export === null || $export->virtualAddress === 0 || $export->size === 0) {
            return null;
        }

        // Move to export section
        $stream->move($sections->virtualAddressToPhysicalOrFail($export->virtualAddress));

        $eat = $this->marshaller->marshal(ExportDirectory::class, $stream);

        // Fetch initial names address
        $nameArrayAddress = $sections->virtualAddressToPhysicalOrFail($eat->addressOfNames);

        for ($i = 0; $i < $eat->numberOfNames; ++$i) {
            $stream->move($nameArrayAddress + $i * 4);

            // Address to export function name
            $nameAddress = $sections->virtualAddressToPhysicalOrFail(
                Converter::toUInt32($stream->read(4), Endianness::ENDIAN_LITTLE)
            );

            // Move to export function name address
            $stream->move($nameAddress);

            if (($name = $this->readNullTerminatedString($stream)) !== '') {
                // TODO Check if this is a jump
                $eat->functions[] = $name;
            }
        }

        return $eat;
    }

    /**
     * @param StreamInterface $stream
     * @return string
     */
    private function readNullTerminatedString(StreamInterface $stream): string
    {
        $buffer = '';

        while (($char = $stream->read(1)) !== "\x00") {
            $buffer .= $char;
        }

        return $buffer;
    }


    /**
     * @param StreamInterface $stream
     * @return CoffHeader
     * @throws ExceptionInterface
     */
    private function readCoffHeader(StreamInterface $stream): CoffHeader
    {
        $coff = $this->marshaller->marshal(CoffHeader::class, $stream);

        if ($coff->signature !== Signature::IMAGE_NT_SIGNATURE) {
            $this->error('Invalid NT signature (0x%X)', $coff->signature);
        }

        $coff->optionalHeader = match ($signature = Converter::toUInt16(Lookahead::read($stream, 2))) {
            OptionalHeaderSignature::PE64 => $this->marshaller->marshal(OptionalHeader64::class, $stream),
            OptionalHeaderSignature::PE32 => $this->marshaller->marshal(OptionalHeader32::class, $stream),
            OptionalHeaderSignature::ROM => throw new \LogicException(
                \sprintf('Unsupported ROM optional header (0x%X).', $signature)
            ),
            default => throw new \LogicException(
                \sprintf('Invalid or unsupported optional header signature (0x%X).', $signature)
            )
        };

        /** @var positive-int|0 $bytes */
        $bytes = $coff->optionalHeader->numberOfRvaAndSizes * 8;

        $coff->optionalHeader->dataDirectories = $this->marshaller->marshal(DataDirectories::class,
            Slice::from($stream, $bytes)
        );

        return $coff;
    }

    /**
     * @param StreamInterface $stream
     * @return DosHeader
     * @throws ExceptionInterface
     */
    private function readDosHeader(StreamInterface $stream): DosHeader
    {
        $dos = $this->marshaller->marshal(DosHeader::class, $stream);

        if ($dos->signature !== Signature::IMAGE_DOS_SIGNATURE) {
            $this->error('Invalid DOS signature (0x%X)', $dos->signature);
        }

        if ($dos->addressOfNewExeHeader <= 0) {
            $this->error('Invalid AddressOfNewExeHeader (0x%X)', $dos->addressOfNewExeHeader);
        }

        return $dos;
    }
}
