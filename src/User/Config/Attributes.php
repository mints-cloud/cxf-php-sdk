<?php

namespace Cxf\User\Config;

trait Attributes
{
    /**
     * Get attributes data types.
     * Get data types used in attributes.
     *
     * Example:
     * $data = $this->getAttributesDataTypes();
     */
    public function getAttributesDataTypes()
    {
        return $this->client->raw('get', '/config/attributes/data-types');
    }

    /**
     * Get sub attributes.
     * Get sub attributes with a slug.
     *
     * Parameters:
     * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
     *
     * Example:
     * $data = $this->getSubAttributes($options);
     */
    public function getSubAttributes($options)
    {
        return $this->client->raw('get', '/config/attributes/sub-attributes', $options);
    }

    /**
     * Get attributes.
     * Get a collection of attributes.
     *
     * Example:
     * $data = $this->getAttributes();
     */
    public function getAttributes()
    {
        return $this->client->raw('get', '/config/attributes');
    }

    /**
     * Get attribute.
     * Get an attribute info.
     *
     * Parameters:
     * $id (int) -- Attribute id.
     *
     * Example:
     * $data = $this->getAttribute(1);
     */
    public function getAttribute($id)
    {
        return $this->client->raw('get', "/config/attributes/{$id}");
    }

    /**
     * Create attribute.
     * Create an attribute with data.
     *
     * Parameters:
     * $data (array) -- Data to be submitted.
     *
     * Example:
     * $data = [
     *     'title' => 'New Attribute',
     *     'object_type' => 'orders',
     *     'slug' => 'new_attribute',
     *     'attribute_group_id' => 1,
     *     'data_type_enum' => 10
     * ];
     * $data = $this->createAttribute($data);
     */
    public function createAttribute($data)
    {
        return $this->client->raw('post', '/config/attributes', null, $this->dataTransform($data));
    }

    /**
     * Update attribute.
     * Update an attribute info.
     *
     * Parameters:
     * $id (int) -- Attribute id.
     * $data (array) -- Data to be submitted.
     *
     * Example:
     * $data = [
     *     'title' => 'New Attribute Modified',
     *     'object_type' => 'orders',
     *     'slug' => 'new_attribute',
     *     'attribute_group_id' => 1,
     *     'data_type_enum' => 10
     * ];
     * $data = $this->updateAttribute(292, $data);
     */
    public function updateAttribute($id, $data)
    {
        return $this->client->raw('put', "/config/attributes/{$id}", null, $this->dataTransform($data));
    }
}