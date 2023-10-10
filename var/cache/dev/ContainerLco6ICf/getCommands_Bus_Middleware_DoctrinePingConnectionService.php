<?php

namespace ContainerLco6ICf;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;

/**
 * @internal This class has been auto-generated by the Symfony Dependency Injection Component.
 */
class getCommands_Bus_Middleware_DoctrinePingConnectionService extends App_KernelDevDebugContainer
{
    /**
     * Gets the private 'commands.bus.middleware.doctrine_ping_connection' shared service.
     *
     * @return \Symfony\Bridge\Doctrine\Messenger\DoctrinePingConnectionMiddleware
     */
    public static function do($container, $lazyLoad = true)
    {
        include_once \dirname(__DIR__, 4).'/vendor/symfony/messenger/Middleware/MiddlewareInterface.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/doctrine-bridge/Messenger/AbstractDoctrineMiddleware.php';
        include_once \dirname(__DIR__, 4).'/vendor/symfony/doctrine-bridge/Messenger/DoctrinePingConnectionMiddleware.php';

        return $container->privates['commands.bus.middleware.doctrine_ping_connection'] = new \Symfony\Bridge\Doctrine\Messenger\DoctrinePingConnectionMiddleware(($container->services['doctrine'] ?? $container->load('getDoctrineService')));
    }
}
