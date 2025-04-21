<?php

namespace Cxf\User\Content;

use Cxf\CxfHelper;

trait Assets
{

    /**
     * Get assets.
     * Get a collection of assets.
     *
     * Parameters:
     * $options (array|null) -- List of Resource Collection Options shown above can be used as parameter.
     * $use_post (bool) -- Variable to determine if the request is by 'post' or 'get' functions.
     *
     * First Example:
     * $data = $cxfUser->getAssets();
     *
     * Second Example:
     * $options = ['fields' => 'id, title'];
     * $data = $cxfUser->getAssets($options);
     *
     * Third Example:
     * $options = ['fields' => 'id, title'];
     * $data = $cxfUser->getAssets($options, true);
     */
    public function getAssets($options = [], $use_post = true)
    {
        return CxfHelper::getQueryResults($this->client, '/content/assets', $options, $use_post);
    }

    /**
     * Get asset.
     * Get an asset info.
     *
     * Parameters:
     * $id (int) -- Asset id.
     * $options (array|null) -- List of Resource Collection Options shown above can be used as parameter.
     *
     * First Example:
     * $data = $cxfUser->getAsset(1);
     *
     * Second Example:
     * $options = ['fields' => 'id, title'];
     * $data = $cxfUser->getAsset(1, $options);
     */
    public function getAsset($id, $options = [])
    {
        return $this->client->raw('get', "/content/assets/{$id}", $options);
    }

    /**
     * Create asset.
     * Create an asset with data.
     *
     * Parameters:
     * $data (array) -- Data to be submitted.
     *
     * Example:
     * $data = [
     *     'title' => 'New Asset',
     *     'slug' => 'new-asset',
     * ];
     * $data = $cxfUser->createAsset($data);
     */
    public function createAsset($data)
    {
        return $this->client->raw('post', '/content/assets', null, $this->dataTransform($data));
    }

    /**
     * Update asset.
     * Update an asset info.
     *
     * Parameters:
     * $id (int) -- Asset id.
     * $data (array) -- Data to be submitted.
     *
     * Example:
     * $data = [
     *     'title' => 'New Asset Modified',
     *     'slug' => 'new-asset'
     * ];
     * $data = $cxfUser->updateAsset(5, $data);
     */
    public function updateAsset($id, $data)
    {
        return $this->client->raw('put', "/content/assets/{$id}", null, $this->dataTransform($data));
    }

    /**
     * Delete asset.
     * Delete an asset.
     *
     * Parameters:
     * $id (int) -- Asset id.
     *
     * Example:
     * $data = $cxfUser->deleteAsset(6);
     */
    public function deleteAsset($id)
    {
        return $this->client->raw('delete', "/content/assets/{$id}");
    }

    public function pasteItemsAssets($data, $options = [])
    {
        return $this->client->raw('post', '/assets/paste', $options, $this->dataTransform($data));
    }

    public function getLinkInfoAssets($options = [])
    {
        return $this->client->raw('get', '/assets/link-info', $options);
    }

    public function sendToTrashAssets($data, $options = [])
    {
        return $this->client->raw('post', '/assets/send-to-trash', $options, $this->dataTransform($data));
    }

    public function usageAssets($id, $options = [])
    {
        return $this->client->raw('get', "/assets/{$id}/usage", $options);
    }
}