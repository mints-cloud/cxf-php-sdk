<?php

namespace Cxf\CPublic\Content;

use Cxf\CxfHelper;

trait PublicAssets
{
    /**
     * Get Asset Info.
     * Get a description of an Asset.
     *
     * @param string $slug It's the string identifier of the asset.
     * @return mixed
     * @throws \Exception
     */
    public function getPublicAsset($slug)
    {
        return $this->client->raw('get', "public-assets/{$slug}", null, null, '/');
    }
}