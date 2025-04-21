<?php

namespace Cxf\Public\Content;

use Cxf\CxfHelper;
trait PrintVersions
{
    public function getPrintVersions($options = [], $use_post = true) {
        return CxfHelper::getQueryResults($this->client, '/content/print-versions', $options, $use_post);
    }

    public function getPrintVersion($id, $options = []) {
        return $this->client->raw('get', "/content/print-versions/{$id}", $options, null);
    }

    public function createPrintVersion($data, $options = []) {
        return $this->client->raw('post', '/content/print-versions', $options, CxfHelper::dataTransform($data));
    }

    public function updatePrintVersion($id, $data, $options = []) {
        return $this->client->raw('put', "/content/print-versions/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deletePrintVersion($id) {
        return $this->client->raw('delete', "/content/print-versions/{$id}", null, null);
    }
}