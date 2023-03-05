<?php

    /** @noinspection PhpMissingFieldTypeInspection */

    namespace RTEX\Objects\Engine\Configuration;

    class RedisHook
    {
        /**
         * If the hook is enabled or not
         * (default: false)
         *
         * @var string
         */
        private $Enabled;

        /**
         * The host of the redis server
         * (default: 127.0.0.1)
         *
         * @var string
         */
        private $Host;

        /**
         * The port of the redis server
         * (default: 6379)
         *
         * @var int
         */
        private $Port;

        /**
         * Optional. Use it only if Redis server requires password (AUTH)
         * (default: null)
         *
         * @var string|null
         */
        private $Password;

        /**
         * Public Constructor
         */
        public function __construct()
        {
            $this->Enabled = false;
            $this->Host = '127.0.0.1';
            $this->Port = 6379;
            $this->Password = null;
        }

        /**
         * Whether the hook is enabled or not
         *
         * @return false|string
         */
        public function isEnabled(): false|string
        {
            return $this->Enabled;
        }

        /**
         * Enables the hook
         *
         * @returns void
         */
        public function enable(): void
        {
            $this->Enabled = true;
        }

        /**
         * Disables the hook
         *
         * @return void
         */
        public function disable(): void
        {
            $this->Enabled = false;
        }

        /**
         * Returns the host of the redis server
         *
         * @return string
         */
        public function getHost(): string
        {
            return $this->Host;
        }

        /**
         * Sets the host of the redis server
         *
         * @param string $Host
         */
        public function setHost(string $Host): void
        {
            $this->Host = $Host;
        }

        /**
         * Returns the port of the redis server
         *
         * @return int
         */
        public function getPort(): int
        {
            return $this->Port;
        }

        /**
         * Sets the port of the redis server
         *
         * @param int $Port
         */
        public function setPort(int $Port): void
        {
            $this->Port = $Port;
        }

        /**
         * Returns the password of the redis server
         *
         * @return string|null
         */
        public function getPassword(): ?string
        {
            return $this->Password;
        }

        /**
         * Sets the password of the redis server
         *
         * @param string|null $Password
         */
        public function setPassword(?string $Password): void
        {
            $this->Password = $Password;
        }

        /**
         * Returns an array representation of the configuration
         *
         * @return array
         */
        public function toArray(): array
        {
            return [
                'enabled' => $this->Enabled,
                'host' => $this->Host,
                'port' => $this->Port,
                'password' => $this->Password
            ];
        }

        /**
         * Constructs a new instance from an array
         *
         * @param array $data
         * @return RedisHook
         */
        public static function fromArray(array $data): self
        {
            $instance = new self();
            $instance->Enabled = ($data['enabled'] ?? false);
            $instance->Host = ($data['host'] ?? '127.0.0.1');
            $instance->Port = ($data['port'] ?? 6379);
            $instance->Password = ($data['password'] ?? null);
            return $instance;
        }
    }