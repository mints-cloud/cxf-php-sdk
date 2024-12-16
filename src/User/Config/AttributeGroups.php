<?php

namespace Cxf\User\Config;

trait AttributeGroups
{
    /**
     * Get attribute groups data types.
     * Get data types used in attribute groups.
     *
     * Example:
     * $data = $this->getAttributeGroupsDataTypes();
     */
    public function getAttributeGroupsDataTypes()
    {
        return $this->client->raw('get', '/config/attribute-groups/object-types');
    }

    /**
     * Get attribute groups.
     * Get a collection of attribute groups.
     *
     * Parameters:
     * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
     *
     * First Example:
     * $data = $this->getAttributeGroups();
     *
     * Second Example:
     * $options = ['sort' => 'id'];
     * $data = $this->getAttributeGroups($options);
     */
    public function getAttributeGroups($options = null)
    {
        return $this->client->raw('get', '/config/attribute-groups', $options);
    }

    /**
     * Get attribute group.
     * Get an attribute group info.
     *
     * Parameters:
     * $id (int) -- Attribute group id.
     *
     * Example:
     * $data = $this->getAttributeGroup(10);
     */
    public function getAttributeGroup($id)
    {
        return $this->client->raw('get', "/config/attribute-groups/{$id}");
    }

    /**
     * Create attribute group.
     * Create an attribute group with data.
     *
     * Parameters:
     * $data (array) -- Data to be submitted.
     *
     * Example:
     * $data = [
     *     'title' => 'New Attribute Group',
     *     'object_type' => 'contacts'
     * ];
     * $data = $this->createAttributeGroup($data);
     */
    public function createAttributeGroup($data)
    {
        return $this->client->raw('post', '/config/attribute-groups', null, $this->dataTransform($data));
    }

    /**
     * Update attribute group.
     * Update an attribute group info.
     *
     * Parameters:
     * $id (int) -- Attribute group id.
     * $data (array) -- Data to be submitted.
     *
     * Example:
     * $data = [
     *     'title' => 'New Attribute Group Modified',
     *     'object_type' => 'contacts',
     *     'slug' => 'new-attribute-group',
     *     'description' => 'New description'
     * ];
     * $data = $this->updateAttributeGroup(36, $data);
     */
    public function updateAttributeGroup($id, $data)
    {
        return $this->client->raw('put', "/config/attribute-groups/{$id}", null, $this->dataTransform($data));
    }
}