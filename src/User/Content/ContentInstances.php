<?php
namespace Cxf\User\Content;
use Cxf\CxfHelper;
trait ContentInstances
{
    public function duplicateContentInstance($id, $data)
    {
        return $this->client->raw('post', "/content/instances/{$id}/duplicate", null, $data);
    }

    public function getContentInstances($options = null, $use_post = true)
    {
        return CxfHelper::getQueryResults($this->client, '/content/instances', $options, $use_post);
    }

    public function getContentInstance($id, $options = null)
    {
        return $this->client->raw('get', "/content/instances/{$id}", $options);
    }

    public function createContentInstance($data, $options = null)
    {
        return $this->client->raw('post', '/content/instances', $options, CxfHelper::dataTransform($data));
    }

    public function createContentInstanceVersion($id, $data, $options = null)
    {
        return $this->client->raw('post', "/content/instances/{$id}/print-version", $options, CxfHelper::dataTransform($data));
    }

    public function addVariantValueToContentInstance($id, $data, $options = null)
    {
        return $this->client->raw('post', "/content/instances/{$id}/variant-value", $options, CxfHelper::dataTransform($data));
    }

    public function deleteVariantValueFromContentInstance($id, $data, $options = null)
    {
        return $this->client->raw('delete', "/content/instances/{$id}/variant-value", $options, CxfHelper::dataTransform($data));
    }

    public function getContentInstanceVariations($id, $options = null)
    {
        return $this->client->raw('get', "/content/instances/{$id}/build-variations", $options);
    }

    public function createItemCodeForContentInstance($id, $data, $options = null)
    {
        return $this->client->raw('post', "/content/instances/{$id}/item-codes", $options, CxfHelper::dataTransform($data));
    }

    public function updateContentInstance($id, $data, $options = null)
    {
        return $this->client->raw('put', "/content/instances/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deleteContentInstance($id)
    {
        return $this->client->raw('delete', "/content/instances/{$id}");
    }
}