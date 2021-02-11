<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Image;

/**
 * @template-extends \IteratorAggregate<positive-int, SectionHeader>
 */
class SectionHeaders implements \IteratorAggregate, \Countable
{
    /**
     * @var array<SectionHeader>
     */
    private array $headers;

    /**
     * @param array<SectionHeader> $headers
     */
    public function __construct(array $headers = [])
    {
        $this->headers = $headers;
    }

    /**
     * @param SectionHeader $header
     */
    public function add(SectionHeader $header): void
    {
        $this->headers[] = $header;
    }

    /**
     * @param int $virtualAddress
     * @return SectionHeader|null
     */
    public function findByVirtualAddress(int $virtualAddress): ?SectionHeader
    {
        foreach ($this->headers as $header) {
            if ($header->contains($virtualAddress)) {
                return $header;
            }
        }

        return null;
    }

    /**
     * @param int $virtualAddress
     * @return int|null
     */
    public function virtualAddressToPhysical(int $virtualAddress): ?int
    {
        return $this->findByVirtualAddress($virtualAddress)?->toPhysical($virtualAddress);
    }

    /**
     * @param int $virtualAddress
     * @return int
     */
    public function virtualAddressToPhysicalOrFail(int $virtualAddress): int
    {
        $addr = $this->virtualAddressToPhysical($virtualAddress);

        if ($addr === null) {
            throw new \OutOfRangeException(
                \sprintf('Can not determine the physical address from the virtual (0x%X)', $virtualAddress)
            );
        }

        return $addr;
    }

    /**
     * @return \Traversable<positive-int, SectionHeader>
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->headers);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return \count($this->headers);
    }
}
