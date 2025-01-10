<?php

namespace Cxf\User\CustomerData;
use Cxf\CxfHelper;

trait EventTemplates {
  /**
   * Get contacts.
   * Get a collection of contacts.
   *
   * Parameters:
   * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
   * $usePost (bool) -- Variable to determine if the request is by 'post' or 'get' functions.
   *
   * First Example:
   * $data = $cxfUser->getEventTemplates();
   *
   * Second Example:
   * $options = [
   *   'sort' => 'id',
   *   'fields[contacts]' => 'id, email'
   * ];
   * $data = $cxfUser->getEventTemplates($options);
   *
   * Third Example:
   * $options = [
   *   'sort' => 'id',
   *   'fields[contacts]' => 'id, email'
   * ];
   * $data = $cxfUser->getEventTemplates($options, true);
   */
  public function getEventTemplates($options = null, $usePost = true) {
    return CxfHelper::getQueryResults($this->client,'/customer-data/utilities/event-templates/', $options, $usePost);
  }

  /**
   * Get contact.
   * Get a contact data.
   *
   * Parameters:
   * $id (int) -- EventTemplate id.
   * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
   *
   * First Example:
   * $data = $cxfUser->getEventTemplate(5);
   *
   * Second Example:
   * $options = [
   *   'sort' => 'id',
   *   'fields[contacts]' => 'id, email'
   * ];
   * $data = $cxfUser->getEventTemplate(5, $options);
   */
  public function getEventTemplate($id, $options = null) {
    return $this->client->raw('get', "/customer-data/utilities/event-templates/{$id}", $options);
  }

  /**
   * Create contact.
   * Create a contact with data.
   *
   * Parameters:
   * $data (array) -- Data to be submitted.
   *
   * Example:
   * $data = [
   *     'email' => 'email@example.com',
   *     'givenName' => 'Given Name',
   *     'lastName' => 'Last Name',
   *     'password' => '123456'
   * ];
   * $data = $cxfUser->createEventTemplate($data);
   */
  public function createEventTemplate($data, $options = null) {
    return $this->client->raw('post', '/customer-data/utilities/event-templates/', $options, $this->dataTransform($data));
  }

  /**
   * Update contact.
   * Update contact data.
   *
   * Parameters:
   * $id (int) -- EventTemplate id.
   * $data (array) -- Data to be submitted.
   *
   * Example:
   * $data = [
   *     'email' => 'email_modified@example.com',
   *     'companyId' => 3
   * ];
   * $data = $cxfUser->updateEventTemplate(65, $data);
   */
  public function updateEventTemplate($id, $data, $options = null) {
    return $this->client->raw('put', "/customer-data/utilities/event-templates/{$id}", $options, $this->dataTransform($data));
  }

  /**
   * Delete contacts.
   * Delete different contacts.
   *
   * Parameters:
   * $id (mongoId) -- EventTemplate id.
   *
   * Example:
   * $id = '5e9c1b8f6b8f6b8f6b8f6b8f';
   * $data = $cxfUser->deleteEventTemplates($id);
   */
  public function deleteEventTemplates($id) {
    return $this->client->raw('delete', "/customer-data/utilities/event-templates/{$id}");
  }

  public function triggerEvent($templateSlug, $data, $options = null) {
    return $this->client->raw('post', "/customer-data/utilities/event-templates/{$templateSlug}/trigger", $options, $this->dataTransform($data));
  }
}
