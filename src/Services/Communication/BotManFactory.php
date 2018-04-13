<?php


namespace App\Services\Communication;


use BotMan\BotMan\Cache\RedisCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Slack\SlackDriver;

/**
 * Class BotManFactory
 * @package App\Services\Communication
 */
class BotManFactory
{
    /**
     * @return \BotMan\BotMan\BotMan
     */
    public static function getInstance() {
        $config = [
            'slack' => [
                'token' => 'xoxb-343431946082-eEmDdybktOIbtieuYWaG6xw0'
            ]
        ];

        DriverManager::loadDriver(SlackDriver::class);

        $botman = \BotMan\BotMan\BotManFactory::create($config, new RedisCache());

        return $botman;
    }

}