<?php

namespace Cxf;

trait PublicAuthTrait
{
    public PublicClient $cxfPublic;

    public function initializePublicClient($host = null, $apiKey = null, $debug = false, $timeouts = []): void
    {
        $this->cxfPublic = new PublicClient($host, $apiKey, $debug, $timeouts);
    }
}