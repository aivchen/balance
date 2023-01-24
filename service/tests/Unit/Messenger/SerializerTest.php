<?php

declare(strict_types=1);

namespace App\Tests\Unit\Messenger;

use App\Messenger\Service\Serializer;
use PHPUnit\Framework\TestCase;

final class SerializerTest extends TestCase
{
    public function testDenormalize(): void
    {
        $serializer = new Serializer();

        $command = $serializer->denormalize(['id' => '1', 'camel_case' => 'CamelCase'], TestMessage::class);

        $this->assertEquals('Name', $command->name);
        $this->assertEquals('CamelCase', $command->camelCase);
    }

    public function testSerialize(): void
    {
        $serializer = new Serializer();

        $encoded = $serializer->serialize(new TestMessage());

        $this->assertEquals('{"name":"Name","camel_case":"CamelCase"}', $encoded);
    }

    public function testDecode(): void
    {
        $serializer = new Serializer();

        $encoded = $serializer->decode('{"name":"Name","camel_case":"CamelCase"}');

        $this->assertEquals(['name' => 'Name', 'camel_case' => 'CamelCase'], $encoded);
    }
}

class TestMessage
{
    public string $name = 'Name';
    public string $camelCase = 'CamelCase';
}
