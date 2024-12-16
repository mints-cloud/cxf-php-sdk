<?php

namespace Cxf;

trait PublicAuthTrait
{
    public PublicClient $cxfPublic;

    public function initializePublicClient($host = null, $apiKey = null, $sessionToken = null, $refreshToken = null, $debug = false, $timeouts = []): void
    {
        $this->cxfPublic = new PublicClient($host, $apiKey, $sessionToken, $refreshToken, $debug, $timeouts);
    }
}