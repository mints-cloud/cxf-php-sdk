<?php

namespace Cxf;

trait PublicAuthTrait
{
    public cPublic $cxfPublic;

    public function initializePublicClient($host = null, $apiKey = null, $sessionToken = null, $refreshToken = null, $debug = false, $timeouts = []): void
    {
        $this->cxfPublic = new cPublic($host, $apiKey, $sessionToken, $refreshToken, $debug, $timeouts);
    }
}