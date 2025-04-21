<?php

namespace Cxf\User\Config;

use Cxf\CxfHelper;
trait Taxonomies
{
    /**
     * Sync taxonomies for object.
     *
     * @param array $data
     * @return mixed
     */
    public function syncTaxonomiesForObject(array $data)
    {
        return $this->client->raw('put', '/config/taxonomies/sync_taxonomies_for_object', null, $this->dataTransform($data));
    }

    /**
     * Get taxonomies for object.
     *
     * @param array $options
     * @return mixed
     */
    public function getTaxonomiesForObject(array $options)
    {
        return $this->client->raw('get', '/config/taxonomies/get_taxonomies_for_object', $options);
    }

    /**
     * Get taxonomies support data.
     *
     * @return mixed
     */
    public function getTaxonomiesSupportData()
    {
        return $this->client->raw('get', '/config/taxonomies/support-data');
    }

    /**
     * Get taxonomies.
     *
     * @param array|null $options
     * @param bool $usePost
     * @return mixed
     */
    public function getTaxonomies(?array $options = [], bool $usePost = true)
    {
        return CxfHelper::getQueryResults($this->client, '/config/taxonomies', $options, $usePost);
    }

    /**
     * Get taxonomy.
     *
     * @param string $id
     * @param array|null $options
     * @return mixed
     */
    public function getTaxonomy(string $idOrSlug, ?array $options = [])
    {
        return $this->client->raw('get', "/config/taxonomies/{$idOrSlug}", $options);
    }

    /**
     * Create taxonomy.
     *
     * @param array $data
     * @param array|null $options
     * @return mixed
     */
    public function createTaxonomy(array $data, ?array $options = [])
    {
        return $this->client->raw('post', '/config/taxonomies', $options, $this->dataTransform($data));
    }

    /**
     * Update taxonomy.
     *
     * @param string $id
     * @param array $data
     * @param array|null $options
     * @return mixed
     */
    public function updateTaxonomy(string $id, array $data, ?array $options = [])
    {
        return $this->client->raw('put', "/config/taxonomies/{$id}", $options, $this->dataTransform($data));
    }

    public function deleteTaxonomy(string $id, ?array $options = [])
    {
        return $this->client->raw('delete', "/config/taxonomies/{$id}", $options);
    }
}
