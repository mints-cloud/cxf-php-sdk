<?php

namespace Cxf\User\Config;

trait Exports
{
    public function getExports(array $options = null)
    {
        return $this->client->raw('get', '/config/export', $options);
    }

    public function getExport(int $id)
    {
        return $this->client->raw('get', "/config/export/{$id}");
    }

    public function getExportJobsUsingViewId(int $id)
    {
        return $this->client->raw('get', "/config/export/{$id}/jobs");
    }
}