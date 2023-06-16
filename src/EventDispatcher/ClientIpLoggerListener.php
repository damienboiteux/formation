<?php
namespace App\EventDispatcher;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

class ClientIpLoggerListener
{

    public function __construct(private LoggerInterface $logger) {}

    public function onKernelRequest(RequestEvent $event)
    {
        $request = $event->getRequest();
        $ip = $request->getClientIp();
        $agent = $request->headers->get('user-agent');
        $path = $request->getPathInfo();
        // $methode = $request->getMethod();
        if("/login" === $path) {
            $this->logger->info("*****************************");
            $this->logger->info("LISTENER - IP: $ip, AGENT: $agent");
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
            $this->logger->info("LISTENER - IP: $ip, AGENT: $agent");
            $this->logger->info("*****************************");
        }
    }
}
