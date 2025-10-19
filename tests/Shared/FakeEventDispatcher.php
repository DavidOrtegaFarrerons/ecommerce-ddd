<?php

namespace App\Tests\Shared;

use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class FakeEventDispatcher implements EventDispatcherInterface
{
    /** @var object[] */
    private array $dispatched = [];

    public function dispatch(object $event, ?string $eventName = null): object
    {
        $this->dispatched[] = $event;
        return $event;
    }

    public function dispatchedEvents(): array
    {
        return $this->dispatched;
    }

    public function hasEventOfType(string $class): bool
    {
        foreach ($this->dispatched as $event) {
            if ($event instanceof $class) {
                return true;
            }
        }
        return false;
    }

    public function addListener(string $eventName, callable $listener, int $priority = 0): void {}
    public function addSubscriber(EventSubscriberInterface $subscriber): void {}
    public function removeListener(string $eventName, callable $listener): void {}
    public function removeSubscriber(EventSubscriberInterface $subscriber): void {}

    public function getListeners(?string $eventName = null): array
    {
        return [];
    }

    public function getListenerPriority(string $eventName, callable $listener): ?int
    {
        return null;
    }

    public function hasListeners(?string $eventName = null): bool
    {
        return !empty($this->dispatched);
    }
}
