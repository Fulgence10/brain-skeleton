<?php

namespace Brain\Event;

class EventManager
{

    private array $listeners = [];

    private static $__instance = null;

    /**
     * 
     * 
     * 
     * 
     */
    public static function getInstance()
    {
        if(is_null(static::$__instance)) {
            static::$__instance = new EventManager();
        }
        return static::$__instance;
    }
   
    /**
     * 
     * 
     * 
     * 
     */
    public function attach(string $eventName, $callback, $priority = 0) : bool
    {
        $this->listeners[$eventName][] = [
            'callback' => $callback,
            'priority' => $priority
        ];
        return true;
    }

    /**
     * 
     * 
     * 
     */
    public function trigger($event, $target = null, $params = []) 
    {
        if(is_string($event)) {
            $event = $this->makeEvent($event, $target, $params);
        }
        if(isset($this->listeners[$event->getName()])) {
            $listener = $this->listeners[$event->getName()];
            usort($listener, function($listenerA, $listenerB) {
                return $listenerB['priority'] - $listenerA['priority'];
            });
            foreach ($listener as ['callback' => $callback]) {
                call_user_func($callback, $event);
            }
        }
    }

    /**
     * 
     * 
     * 
     */
    public function detach($eventName, $callback) 
    {
        $this->listeners[$eventName] = array_filter($this->listeners[$eventName], function($listener) use ($callback) {
            return $listener['callback'] !== $callback;
        });

        return true;
    }

    /**
     * 
     * 
     * 
     */
    public function clearListener($eventName) 
    {
        $this->listeners[$eventName] = [];
    }

    /**
     * 
     * 
     * 
     */
    private function makeEvent($eventName, $target = null, $params = []) 
    {
        $event = new Event();
        $event->setName($eventName);
        $event->setTarget($target);
        $event->setParams($params);
        return $event;
    }
}
