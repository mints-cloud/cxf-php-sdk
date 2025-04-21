<?php

namespace Cxf\User\Config;

trait Exports
{
    public function getExports(array $options = [])
    {
        return $this->client->raw('get', '/config/export', $options);
    }

    public function getExport(string $id)
    {
        return $this->client->raw('get', "/config/export/{$id}");
    }

    public function getExportJobsUsingViewId(string $id)
    {
        return $this->client->raw('get', "/config/export/{$id}/jobs");
    }
}