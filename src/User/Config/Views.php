<?php

namespace Cxf\User\Config;

use Cxf\CxfHelper;

trait Views
{
    public function getViews($options = [])
    {
        return $this->client->raw('get', '/config/views', $options);
    }

    public function getView($id)
    {
        return $this->client->raw('get', "/config/views/{$id}");
    }

    public function createView($data)
    {
        return $this->client->raw('post', '/config/views', null, CxfHelper::dataTransform($data));
    }

    public function updateView($id, $data)
    {
        return $this->client->raw('put', "/config/views/{$id}", null, CxfHelper::dataTransform($data));
    }

    public function getViewQuery($idOrSlug)
    {
        return $this->client->raw('get', "/config/views/{$idOrSlug}/query");
    }

    public function exportViewToBigQuery($idOrSlug)
    {
        return $this->client->raw('post', "/config/views/{$idOrSlug}/export");
    }
}