<?php

declare(strict_types=1);

namespace App\Messenger\Service;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\MessageDecodingFailedException;
use Symfony\Component\Messenger\Stamp\NonSendableStampInterface;
use Symfony\Component\Messenger\Stamp\StampInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;

final class JsonMessengerSerializer implements SerializerInterface
{
    public function __construct(
        private readonly MessageConverter $converter,
    ) {
    }

    /**
     * @psalm-suppress MoreSpecificImplementedParamType
     * @param array{body: string, headers: array<string, string>} $encodedEnvelope
     */
    public function decode(array $encodedEnvelope): Envelope
    {
        $body = $encodedEnvelope['body'];
        $headers = $encodedEnvelope['headers'];

        try {
            $message = $this->converter->decode($body);
        } catch (\Exception $e) {
            throw new MessageDecodingFailedException('Failed to make message', 0, $e);
        }

        // in case of redelivery, unserialize any stamps
        $stamps = [];
        if (isset($headers['stamps'])) {
            /** @var StampInterface[] $stamps */
            $stamps = unserialize($headers['stamps']);
        }
        return new Envelope($message, $stamps);
    }

    public function encode(Envelope $envelope): array
    {
        $envelope = $envelope->withoutStampsOfType(NonSendableStampInterface::class);

        $message = $envelope->getMessage();
        $body = $this->converter->encode($message);

        $headers = [];
        $allStamps = [];
        /** @var StampInterface[] $stamps */
        foreach ($envelope->all() as $stamps) {
            $allStamps[] = $stamps;
        }
        $allStamps = array_merge(...$allStamps);

        $headers['stamps'] = serialize($allStamps);

        return [
            'body' => $body,
            'headers' => $headers,
        ];
    }
}
