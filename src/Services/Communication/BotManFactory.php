<?php


namespace App\Services\Communication;


use BotMan\BotMan\Cache\SymfonyCache;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\Drivers\Slack\SlackDriver;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

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
                'token' => 'xoxb-343431946082-0dH9nptR4uZzUP4uWshcmG7M'
            ]
        ];

        DriverManager::loadDriver(SlackDriver::class);

        $adapter = new FilesystemAdapter();
        $botman = \BotMan\BotMan\BotManFactory::create($config, new SymfonyCache($adapter));

        return $botman;
    }

}