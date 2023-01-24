<?php

declare(strict_types=1);

namespace App\Messenger\Service;

use App\Messenger\Messages\Message;

/**
 * @psalm-suppress MixedArgument
 */
final class MessageConverter
{
    private Serializer $serializer;

    /**
     * @param class-string<Message>[] $messageClasses
     */
    public function __construct(private readonly array $messageClasses)
    {
        $this->serializer = new Serializer();
    }

    public function decode(string $data): object
    {
        $decoded = $this->serializer->decode($data);
        if (!isset($decoded['name'])) {
            throw new \InvalidArgumentException('Name field is not set');
        }

        foreach ($this->messageClasses as $class) {
            if ($class::getName() === $decoded['name']) {
                return $this->serializer->denormalize($decoded, $class);
            }
        }
        throw new \InvalidArgumentException('Message type is not supported');
    }

    public function encode(object $data): string
    {
        return $this->serializer->serialize($data);
    }
}
