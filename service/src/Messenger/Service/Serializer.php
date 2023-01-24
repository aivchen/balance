<?php

declare(strict_types=1);

namespace App\Messenger\Service;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\NameConverter\CamelCaseToSnakeCaseNameConverter;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer as SymfonySerializer;

final class Serializer
{
    private SymfonySerializer $serializer;

    public function __construct()
    {
        $this->serializer = new SymfonySerializer(
            [new ObjectNormalizer(null, new CamelCaseToSnakeCaseNameConverter())],
            [new JsonEncoder()]
        );
    }

    public function serialize(object $message): string
    {
        return $this->serializer->serialize($message, 'json');
    }

    /**
     * @return array<string, mixed>
     */
    public function decode(string $data): array
    {
        /** @var array<string, mixed> */
        return $this->serializer->decode($data, 'json');
    }

    /**
     * @template T
     * @param array $data
     * @param class-string<T> $target
     * @return T
     */
    public function denormalize(array $data, string $target): object
    {
        /** @var T */
        return $this->serializer->denormalize($data, $target);
    }
}
