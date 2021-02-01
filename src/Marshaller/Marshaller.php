<?php

/**
 * This file is part of PEReader package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Serafim\PEReader\Marshaller;

use Doctrine\Common\Annotations\AnnotationReader as DoctrineAnnotationReader;
use Doctrine\Instantiator\Exception\ExceptionInterface;
use Doctrine\Instantiator\Instantiator;
use Doctrine\Instantiator\InstantiatorInterface;
use Serafim\PEReader\Marshaller\Type\TypeInterface;
use Serafim\PEReader\Stream\StreamInterface;
use Spiral\Attributes\AnnotationReader;
use Spiral\Attributes\AttributeReader;
use Spiral\Attributes\Composite\SelectiveReader;
use Spiral\Attributes\ReaderInterface;

class Marshaller implements MarshallerInterface
{
    /**
     * @var InstantiatorInterface
     */
    private InstantiatorInterface $instantiator;

    /**
     * @var ReaderInterface
     */
    private ReaderInterface $reader;

    /**
     * @param ReaderInterface|null $reader
     * @param InstantiatorInterface|null $instantiator
     */
    public function __construct(
        ReaderInterface $reader = null,
        InstantiatorInterface $instantiator = null
    ) {
        $this->reader = $reader ?? $this->createReader();
        $this->instantiator = $instantiator ?? new Instantiator();
    }

    /**
     * @return ReaderInterface
     */
    private function createReader(): ReaderInterface
    {
        if (! \class_exists(DoctrineAnnotationReader::class)) {
            return new AttributeReader();
        }

        return new SelectiveReader([new AttributeReader(), new AnnotationReader()]);
    }

    /**
     * {@inheritDoc}
     * @throws ExceptionInterface
     */
    public function marshal(object|string $struct, StreamInterface $stream): object
    {
        if (\is_string($struct)) {
            $struct = $this->instantiate($struct);
        }

        foreach ($this->fields($struct) as $field => $attr) {
            if (! $field->isPublic()) {
                $field->setAccessible(true);
            }

            $field->setValue($struct, $attr->marshal($stream, $this));
        }

        return $struct;
    }

    /**
     * @psalm-template TStruct of object
     *
     * @param class-string<TStruct> $class
     * @return TStruct
     * @throws ExceptionInterface
     */
    private function instantiate(string $class): object
    {
        return $this->instantiator->instantiate($class);
    }

    /**
     * @param object|class-string $struct
     * @return iterable<\ReflectionProperty, TypeInterface>
     */
    private function fields(object|string $struct): iterable
    {
        try {
            $reflection = new \ReflectionClass($struct);
        } catch (\ReflectionException) {
            return [];
        }

        foreach ($reflection->getProperties() as $property) {
            $attribute = $this->reader->firstPropertyMetadata($property, TypeInterface::class);

            if ($attribute instanceof TypeInterface) {
                yield $property => $attribute;
            }
        }
    }

    /**
     * @param object|class-string $struct
     * @return int
     */
    public function sizeOf(object|string $struct): int
    {
        $accum = 0;

        foreach ($this->fields($struct) as $attr) {
            $accum += $attr->bytes($this);
        }

        return $accum;
    }
}
