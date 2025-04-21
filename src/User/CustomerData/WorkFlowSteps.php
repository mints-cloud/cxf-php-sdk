<?php

namespace Cxf\User\CustomerData;
use Cxf\CxfHelper;
trait WorkFlowSteps
{
    public function getWorkflowSteps($options = [], $use_post = true)
    {
        return CxfHelper::getQueryResults($this->client, '/customer-data/workflows-steps', $options, $use_post);
    }

    public function getWorkflowStep($id, $options = [])
    {
        return $this->client->raw('get', "/customer-data/workflows-steps/{$id}", $options, null);
    }

    public function createWorkflowStep($data, $options = [])
    {
        return $this->client->raw('post', '/customer-data/workflows-steps/', $options, CxfHelper::dataTransform($data));
    }

    public function attachWorkflowStep($id, $data, $options = [])
    {
        return $this->client->raw('put', "/customer-data/workflows-steps/{$id}/attach-item", $options, CxfHelper::dataTransform($data));
    }

    public function detachWorkflowStep($id, $data, $options = [])
    {
        return $this->client->raw('put', "/customer-data/workflows-steps/{$id}/detach-item", $options, CxfHelper::dataTransform($data));
    }

    public function updateWorkflowStep($id, $data, $options = [])
    {
        return $this->client->raw('put', "/customer-data/workflows-steps/{$id}", $options, CxfHelper::dataTransform($data));
    }

    public function deleteWorkflowSteps($data)
    {
        return $this->client->raw('delete', '/customer-data/workflows-steps/delete', null, CxfHelper::dataTransform($data));
    }
}
