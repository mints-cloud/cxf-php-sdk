<?php
namespace Cxf\User\Content;
use Cxf\CxfHelper;
trait ContentTemplates
{
    public function getContentTemplates($options = [], $usePost = true)
    {
        return CxfHelper::getQueryResults($this->client, '/content/templates', $options, $usePost);
    }

    public function getContentTemplate($id, $options = [])
    {
        return $this->client->raw('get', "/content/templates/{$id}", $options);
    }

    public function createContentTemplate($data, $options = [])
    {
        return $this->client->raw('post', '/content/templates', $options, CxfHelper::dataTransform($data));
    }

    public function createContentTemplateVariantOption($id, $data, $options = [])
    {
        return $this->client->raw('post', "/content/templates/{$id}/variant-option", $options, CxfHelper::dataTransform($data));
    }

    public function deleteContentTemplateVariantOption($id, $data, $options = [])
    {
        return $this->client->raw('delete', "/content/templates/{$id}/variant-option", $options, CxfHelper::dataTransform($data));
    }

    public function updateContentTemplate($id, $data)
    {
        return $this->client->raw('put', "/content/templates/{$id}", null, CxfHelper::dataTransform($data));
    }
}