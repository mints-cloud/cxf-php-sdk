<?php

namespace Cxf\User\Content;

use Cxf\CxfHelper;
trait PrintVersions
{
    public function getPrintVersions($options = null, $usePost = true)
    {
        return CxfHelper::getQueryResults($this->client, '/content/print-versions', $options, $usePost);
    }

    public function getPrintVersion($id, $options = null)
    {
        return $this->client->raw('get', "/content/print-versions/{$id}", $options);
    }

    public function createPrintVersion($data, $options = null)
    {
        return $this->client->raw('post', '/content/print-versions', $options, CxfHelper::dataTransform($data));
    }

    public function createPrintVersionFromPrintVersion($id, $data, $options = null)
    {
        return $this->client->raw('post', "/content/print-versions/{$id}/print-version", $options, CxfHelper::dataTransform($data));
    }

    public function updatePrintVersion($id, $data, $options = null)
    {
        return $this->client->raw('put', "/content/print-versions/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deletePrintVersion($id)
    {
        return $this->client->raw('delete', "/content/print-versions/{$id}");
    }

    public function duplicatePrintVersion($id, $data)
    {
        return $this->client->raw('post', "/content/print-versions/{$id}/duplicate", null, $data);
    }

    public function publishPrintVersion($id, $data)
    {
        return $this->client->raw('put', "/content/print-versions/{$id}/publish", null, $data);
    }
}