<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX\Objects\Engine;

    use RTEX\Objects\Engine\Configuration\RedisHook;

    class Configuration
    {
        /**
         * The redis hook configuration
         *
         * @var RedisHook
         */
        private $RedisHook;

        public function __construct()
        {
            $this->RedisHook = new RedisHook();
        }

        /**
         * Returns the redis hook configuration
         *
         * @return RedisHook
         */
        public function getRedisHook(): RedisHook
        {
            return $this->RedisHook;
        }

        /**
         * Returns an array representation of the configuration
         *
         * @return array
         */
        public function toArray(): array
        {
            return [
                'redis_hook' => $this->RedisHook->toArray()
            ];
        }

        /**
         * Constructs a configuration object from an array
         *
         * @param array $data
         * @return static
         */
        public static function fromArray(array $data): self
        {
            $instance = new self();
            $instance->RedisHook = RedisHook::fromArray(($data['redis_hook'] ?? []));
            return $instance;
        }
    }