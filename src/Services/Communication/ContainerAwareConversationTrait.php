<?php
namespace App\Services\Communication;

use App\Kernel;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

trait ContainerAwareConversationTrait
{
    use ContainerAwareTrait;

    public function __sleep()
    {
        $this->setContainer(null);
        return parent::__sleep();
    }

    public function __wakeup()
    {
        $env = $_SERVER['APP_ENV'] ?? 'dev';
        $debug = (bool) ($_SERVER['APP_DEBUG'] ?? ('prod' !== $env));
        $kernel = new Kernel($env, $debug);
        $kernel->boot();
        $this->setContainer($kernel->getContainer());
    }
}