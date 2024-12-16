<?php

namespace Cxf\User\CustomerData;
trait Workflows
{

    /**
     * Get workflows.
     * Get a collection of workflows.
     *
     * Parameters:
     * $options (array|null) -- List of Resource Collection Options shown above can be used as parameter.
     *
     * First Example:
     * $data = $cxfUser->getWorkflows();
     *
     * Second Example:
     * $options = ['sort' => 'title', 'fields' => 'title'];
     * $data = $cxfUser->getWorkflows($options);
     */
    public function getWorkflows($options = null)
    {
        return $this->client->raw('get', '/customer-data/workflows', $options);
    }

    /**
     * Get workflow.
     * Get a workflow.
     *
     * Parameters:
     * $id (int) -- Workflow id.
     * $options (array|null) -- List of Resource Collection Options shown above can be used as parameter.
     *
     * First Example:
     * $data = $cxfUser->getWorkflow(1);
     *
     * Second Example:
     * $options = ['fields' => 'id, title'];
     * $data = $cxfUser->getWorkflow(1, $options);
     */
    public function getWorkflow($id, $options = null)
    {
        return $this->client->raw('get', "/customer-data/workflows/{$id}", $options);
    }

    /**
     * Create workflow.
     * Create a workflow with data.
     *
     * Parameters:
     * $data (array) -- Data to be submitted.
     *
     * Example:
     * $data = [
     *     'title' => 'New Workflow',
     *     'object_type' => 'deals'
     * ];
     * $data = $cxfUser->createWorkflow(json_encode($data));
     */
    public function createWorkflow($data, $options = null)
    {
        return $this->client->raw('post', '/customer-data/workflows/', $options, $data);
    }

    /**
     * Update workflow.
     * Update a workflow info.
     *
     * Parameters:
     * $id (int) -- Workflow id.
     * $data (array) -- Data to be submitted.
     *
     * Example:
     * $data = [
     *     'title' => 'New Workflow Modified'
     * ];
     * $data = $cxfUser->updateWorkflow(7, $data);
     */
    public function updateWorkflow($id, $data, $options = null)
    {
        return $this->client->raw('put', "/customer-data/workflows/{$id}", $options, $this->correctJson($data));
    }

    public function checkWorkflowObjectSteps($id, $data, $options = null)
    {
        return $this->client->raw('put', "/customer-data/workflows/{$id}/object-step/check-item", $options, $data);
    }

    public function updateWorkflowObjectSteps($id, $data, $options = null)
    {
        return $this->client->raw('put', "/customer-data/workflows/{$id}/object-step", $options, $data);
    }
}
