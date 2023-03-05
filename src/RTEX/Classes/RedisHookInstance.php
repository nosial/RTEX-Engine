<?php /** @noinspection PhpMissingFieldTypeInspection */

namespace RTEX\Classes;

    use RedisClient\RedisClient;

    class RedisHookInstance
    {
        public function __construct(string $host, int $port, ?string $password=null)
        {
            if(extension_loaded('redis'))
            {
                $this->Redis = new \Redis();
                $this->Redis->connect($host, $port);
                if($password !== null)
                    $this->Redis->auth($password);
            }
            else
            {
                $this->Redis = new RedisClient([
                    'host' => $host,
                    'port' => $port,
                    'password' => $password
                ]);
            }
        }
    }