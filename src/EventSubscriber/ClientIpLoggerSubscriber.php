<?php

namespace App\EventSubscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ClientIpLoggerSubscriber implements EventSubscriberInterface
{

    public function __construct(private LoggerInterface $logger) {}

    public function onKernelRequest(RequestEvent $event): void
    {
        $request = $event->getRequest();
        $ip = $request->getClientIp();
        $agent = $request->headers->get('user-agent');
        $path = $request->getPathInfo();
        // $methode = $request->getMethod();
        $request->attributes->set('ip', $ip);
        if("/login" === $path) {
            $this->logger->info("*****************************");
            $this->logger->info("SUBSCRIBER - IP: $ip, AGENT: $agent");
            $this->logger->info("*****************************");
        }
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        $request = $event->getRequest();
        $ip = $request->getClientIp();
        $agent = $request->headers->get('user-agent');
        $path = $request->getPathInfo();
        // $methode = $request->getMethod();
        if("/login" === $path) {
            $this->logger->info("*****************************");
            $this->logger->info("SUBSCRIBER - IP: $ip, AGENT: $agent");
            $this->logger->info("*****************************");
        }
    }

    public static function getSubscribedEvents(): array
    {
        return [
            // KernelEvents::REQUEST => 'onKernelRequest',
            'kernel.request' => 'onKernelRequest',
            'kernel.response' => 'onKernelResponse',
        ];
    }
}
