<?php

namespace Cxf\User\Config;
use Cxf\CxfHelper;

trait Docs
{
    public function generateDocs($data)
    {
        return $this->client->raw('post', '/config/docs/generate', null, CxfHelper::dataTransform($data));
    }

    public function getDocJobs()
    {
        return $this->client->raw('get', '/config/docs/jobs');
    }
}