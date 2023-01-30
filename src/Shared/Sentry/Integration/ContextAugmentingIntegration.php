<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Sentry\Integration;

use Sentry\Event;
use Sentry\Integration\IntegrationInterface;
use Sentry\SentrySdk;
use Sentry\State\Scope;

final class ContextAugmentingIntegration implements IntegrationInterface
{
    /**
     * @param array<string, string> $tags
     * @param array<string, mixed> $extra
     */
    public function __construct(
        public array $tags = [],
        public array $extra = [],
    ) {
    }

    public function setupOnce(): void
    {
        Scope::addGlobalEventProcessor(static function (Event $event): Event {
            $integration = SentrySdk::getCurrentHub()->getIntegration(self::class);
            $integration?->addTags($event, $integration->tags);
            $integration?->addExtra($event, $integration->extra);

            return $event;
        });
    }

    /**
     * @param array<string, string> $tags
     */
    public function addTags(Event $event, array $tags): void
    {
        $event->setTags(array_merge($event->getTags(), $tags));
    }

    /**
     * @param array<string, mixed> $extra
     */
    public function addExtra(Event $event, array $extra): void
    {
        $event->setExtra(array_merge($event->getExtra(), $extra));
    }
}
