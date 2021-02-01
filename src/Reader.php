<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader;

use Doctrine\Instantiator\InstantiatorInterface;
use JetBrains\PhpStorm\NoReturn;
use Serafim\PEReader\Image\Dos\Header as DosHeader;
use Serafim\PEReader\Image\Nt\Header as NtHeader;
use Serafim\PEReader\Image\Signature;
use Serafim\PEReader\Marshaller\Marshaller;
use Serafim\PEReader\Marshaller\MarshallerInterface;
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
    public function read(StreamInterface $stream): iterable
    {
        yield $dos = $this->marshaller->marshal(DosHeader::class, $stream);

        if ($dos->signature !== Signature::IMAGE_DOS_SIGNATURE) {
            $this->error('Invalid DOS signature "0x%X"', $dos->signature);
        }

        if ($dos->addressOfNewExeHeader <= 0) {
            $this->error('Invalid AddressOfNewExeHeader = 0x%X', $dos->addressOfNewExeHeader);
        }

        $stream->move($dos->addressOfNewExeHeader);

        yield $nt = $this->marshaller->marshal(NtHeader::class, $stream);

        if ($nt->signature !== Signature::IMAGE_NT_SIGNATURE) {
            $this->error('Invalid NT signature "0x%X"', $nt->signature);
        }
    }
}
