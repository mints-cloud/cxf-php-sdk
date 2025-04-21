<?php

namespace Cxf\User\Content;

trait Content
{
    use Assets;
    use Blocks;
    use BlockTemplates;
    use Bundles;
    use ContentPrints;
    use ContentInstances;
    use MessageTemplates;
    use PrintVersions;
    use ContentTemplates;

    /**
     * Get public images URL.
     * Get public images URL.
     *
     * Example:
     * $data = $this->getPublicImagesUrl();
     */
    public function getPublicImagesUrl()
    {
        return $this->client->raw('get', '/content/public-images-url');
    }

    /**
     * Get keywords.
     * Get a collection of keywords.
     *
     * Parameters:
     * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
     *
     * First Example:
     * $data = $this->getKeywords();
     *
     * Second Example:
     * $options = ['fields' => 'title'];
     * $data = $this->getKeywords($options);
     */
    public function getKeywords($options = [])
    {
        return $this->client->raw('get', '/content/keywords', $options);
    }

    /**
     * Get keyword.
     * Get a keyword.
     *
     * Parameters:
     * $id (int) -- Keyword id.
     *
     * Example:
     * $data = $this->getKeyword(1);
     */
    public function getKeyword($id)
    {
        return $this->client->raw('get', "/content/keywords/{$id}");
    }

    /**
     * Create keyword.
     * Create a keyword with data.
     *
     * Parameters:
     * $data (array) -- Data to be submitted.
     *
     * Example:
     * $data = ['title' => 'New Keyword'];
     * $data = $this->createKeyword($data);
     */
    public function createKeyword($data)
    {
        return $this->client->raw('post', '/content/keywords', null, $data);
    }

    /**
     * Update keyword.
     * Update a keyword info.
     *
     * Parameters:
     * $id (int) -- Keyword id.
     * $data (array) -- Data to be submitted.
     *
     * Example:
     * $data = ['title' => 'New Keyword Modified'];
     * $data = $this->updateKeyword(1, $data);
     */
    public function updateKeyword($id, $data)
    {
        // FIXME: Keyword controller doesn't receive data
        return $this->client->raw('put', "/content/keywords/{$id}", null, $data);
    }

    /**
     * Get stages.
     * Get a collection of stages.
     *
     * Parameters:
     * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
     *
     * First Example:
     * $data = $this->getStages();
     *
     * Second Example:
     * $options = ['fields' => 'title'];
     * $data = $this->getStages($options);
     */
    public function getStages($options = [])
    {
        return $this->client->raw('get', '/content/stages', $options);
    }

    /**
     * Get stage.
     * Get a stage.
     *
     * Parameters:
     * $id (int) -- Stage id.
     *
     * Example:
     * $data = $this->getStage(1);
     */
    public function getStage($id)
    {
        return $this->client->raw('get', "/content/stages/{$id}");
    }

    /**
     * Create stage.
     * Create a stage with data.
     *
     * Parameters:
     * $data (array) -- Data to be submitted.
     *
     * Example:
     * $configJson = ['count' => 1];
     * $eventJson = ['rset' => 'DTSTART:20190214T000000Z', 'duration' => 1];
     * $data = ['title' => 'New Stage', 'description' => 'New Stage Description', 'config_json' => json_encode($configJson), 'event_json' => json_encode($eventJson)];
     * $data = $this->createStage($data);
     */
    public function createStage($data)
    {
        return $this->client->raw('post', '/content/stages', null, $data);
    }

    /**
     * Update stage.
     * Update a stage info.
     *
     * Parameters:
     * $id (int) -- Stage id.
     * $data (array) -- Data to be submitted.
     *
     * Example:
     * $configJson = ['count' => 2];
     * $eventJson = ['rset' => 'DTSTART:20190214T000000Z', 'duration' => 2];
     * $data = ['stageProps' => ['title' => 'New Stage Modified', 'description' => 'New Stage Description Modified'], 'config_json' => json_encode($configJson), 'event_json' => json_encode($eventJson)];
     * $data = $this->updateStage(3, $data);
     */
    public function updateStage($id, $data)
    {
        // TODO: Inform StageController.update method has been modified
        return $this->client->raw('put', "/content/stages/{$id}", null, $data);
    }
}