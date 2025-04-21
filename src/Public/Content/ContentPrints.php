<?php

namespace Cxf\Public\Content;

use Cxf\CxfHelper;

trait ContentPrints
{
    public function getContentPrints($options = [], $use_post = true) {
        return CxfHelper::getQueryResults($this->client, '/content/prints', $options, $use_post);
    }

    public function getContentPrint($id, $options = []) {
        return $this->client->raw('get', "/content/prints/{$id}", $options, null);
    }

    public function updateContentPrint($id, $data, $options = []) {
        return $this->client->raw('put', "/content/prints/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deleteContentPrint($id) {
        return $this->client->raw('delete', "/content/prints/{$id}", null, null);
    }
}