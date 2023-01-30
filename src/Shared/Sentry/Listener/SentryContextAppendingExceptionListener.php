<?php

declare(strict_types=1);

namespace Karma8\SubscriptionNotifier\Shared\Sentry\Listener;

use Karma8\SubscriptionNotifier\Shared\Cast\Cast;
use Karma8\SubscriptionNotifier\Shared\Sentry\Exception\ExtraAwareException;
use Karma8\SubscriptionNotifier\Shared\Sentry\Exception\TagsAwareException;
use Sentry\State\HubInterface;
use Sentry\State\Scope;
use Symfony\Component\Console\Event\ConsoleErrorEvent;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;

final class SentryContextAppendingExceptionListener
{
    public function __construct(
        private readonly HubInterface $hub,
    ) {
    }

    public function onExceptionEvent(ExceptionEvent $event): void
    {
        $this->handleException($event->getThrowable());
    }

    public function onConsoleErrorEvent(ConsoleErrorEvent $event): void
    {
        $this->handleException($event->getError());
    }

    private function handleException(Throwable $exception): void
    {
        if ($exception instanceof TagsAwareException) {
            $this->addTagsFromException($exception);
        }
        if ($exception instanceof ExtraAwareException) {
            $this->addExtraFromException($exception);
        }
    }

    private function addTagsFromException(TagsAwareException $exception): void
    {
        $this->hub->configureScope(static function (Scope $scope) use ($exception): void {
            foreach ($exception->sentryTags() as $key => $value) {
                $scope->setTag($key, Cast::string($value));
            }
        });
    }

    private function addExtraFromException(ExtraAwareException $exception): void
    {
        $this->hub->configureScope(static function (Scope $scope) use ($exception): void {
            foreach ($exception->sentryExtra() as $key => $value) {
                $scope->setExtra($key, $value);
            }
        });
    }
}
