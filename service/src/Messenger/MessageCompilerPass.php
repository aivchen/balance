<?php

declare(strict_types=1);

namespace App\Messenger;

use App\Messenger\Service\MessageConverter;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

final class MessageCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $services = $container->findTaggedServiceIds('messenger.message');

        $messageClasses = [];
        foreach ($services as $id => $_) {
            $def = $container->getDefinition($id);
            if ($c = $def->getClass()) {
                $messageClasses[] = $c;
            }
        }
        $factory = $container->getDefinition(MessageConverter::class);
        $factory->addArgument($messageClasses);
    }
}
