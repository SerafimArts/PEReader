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
use Serafim\PEReader\Image\Dos\Header as DosHeader;
use Serafim\PEReader\Image\ImageSignature;
use Serafim\PEReader\Image\Nt\Header as NtHeader;
use Serafim\PEReader\Image\OptionalHeader\DataDirectories;
use Serafim\PEReader\Image\OptionalHeader\OptionalHeader32;
use Serafim\PEReader\Image\OptionalHeader\OptionalHeader64;
use Serafim\PEReader\Image\OptionalHeader\OptionalHeaderSignature;
use Serafim\PEReader\Marshaller\Bin\Converter;
use Serafim\PEReader\Marshaller\Marshaller;
use Serafim\PEReader\Marshaller\MarshallerInterface;
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
    private function error(
        string $message,
        ...$args
    ): void {
        throw new \LogicException(\vsprintf($message, $args));
    }

    /**
     * {@inheritDoc}
     * @throws \Throwable
     */
    public function read(StreamInterface $stream): iterable
    {
        // Read MS DOS header
        yield $dos = $this->readDosHeader($stream);

        // Move to NT header
        $stream->move($dos->addressOfNewExeHeader);

        // Read NT header
        yield $nt = $this->readNtHeader($stream);
    }

    /**
     * @param StreamInterface $stream
     * @return NtHeader
     * @throws ExceptionInterface
     */
    private function readNtHeader(StreamInterface $stream): NtHeader
    {
        $nt = $this->marshaller->marshal(NtHeader::class, $stream);

        if ($nt->signature !== ImageSignature::IMAGE_NT_SIGNATURE) {
            $this->error('Invalid NT signature "0x%X"', $nt->signature);
        }

        $nt->optionalHeader = match ($header = Converter::toUInt16(Lookahead::read($stream, 2))) {
            OptionalHeaderSignature::PE64 => $this->marshaller->marshal(OptionalHeader64::class, $stream),
            OptionalHeaderSignature::PE32 => $this->marshaller->marshal(OptionalHeader32::class, $stream),
            default => throw new \LogicException(\sprintf('Invalid or unsupported optional header signature "0x%X".', $header))
        };

        /** @var positive-int|0 $bytes */
        $bytes = $nt->optionalHeader->numberOfRvaAndSizes * 8;

        $nt->optionalHeader->dataDirectories = $this->marshaller->marshal(DataDirectories::class,
            Slice::from($stream, $bytes)
        );

        return $nt;
    }

    /**
     * @param StreamInterface $stream
     * @return DosHeader
     * @throws ExceptionInterface
     */
    private function readDosHeader(StreamInterface $stream): DosHeader
    {
        $dos = $this->marshaller->marshal(DosHeader::class, $stream);

        if ($dos->signature !== ImageSignature::IMAGE_DOS_SIGNATURE) {
            $this->error('Invalid DOS signature "0x%X"', $dos->signature);
        }

        if ($dos->addressOfNewExeHeader <= 0) {
            $this->error('Invalid AddressOfNewExeHeader = 0x%X', $dos->addressOfNewExeHeader);
        }

        return $dos;
    }
}
