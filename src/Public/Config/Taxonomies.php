<?php

namespace Cxf\Public\Config;

use Cxf\CxfHelper;

trait Taxonomies
{
    public function getTaxonomies($options = [], $use_post = true) {
        return CxfHelper::getQueryResults($this->client, '/config/taxonomies', $options, $use_post);
    }

    public function getTaxonomy($id, $options = []) {
        return $this->client->raw('get', "/config/taxonomies/{$id}", $options, null);
    }
}