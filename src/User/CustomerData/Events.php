<?php

namespace Cxf\User\CustomerData;
use Cxf\CxfHelper;

trait Events {
  /**
   * Get contacts.
   * Get a collection of contacts.
   *
   * Parameters:
   * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
   * $usePost (bool) -- Variable to determine if the request is by 'post' or 'get' functions.
   *
   * First Example:
   * $data = $cxfUser->getEvents();
   *
   * Second Example:
   * $options = [
   *   'sort' => 'id',
   *   'fields[contacts]' => 'id, email'
   * ];
   * $data = $cxfUser->getEvents($options);
   *
   * Third Example:
   * $options = [
   *   'sort' => 'id',
   *   'fields[contacts]' => 'id, email'
   * ];
   * $data = $cxfUser->getEvents($options, true);
   */
  public function getEvents($options = [], $usePost = true) {
    return CxfHelper::getQueryResults($this->client,'/customer-data/utilities/events/', $options, $usePost);
  }

  /**
   * Get contact.
   * Get a contact data.
   *
   * Parameters:
   * $id (int) -- Event id.
   * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
   *
   * First Example:
   * $data = $cxfUser->getEvent(5);
   *
   * Second Example:
   * $options = [
   *   'sort' => 'id',
   *   'fields[contacts]' => 'id, email'
   * ];
   * $data = $cxfUser->getEvent(5, $options);
   */
  public function getEvent($id, $options = []) {
    return $this->client->raw('get', "/customer-data/utilities/events/{$id}", $options);
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
   * $data = $cxfUser->createEvent($data);
   */
  public function createEvent($data, $options = []) {
    return $this->client->raw('post', '/customer-data/utilities/events/', $options, $this->dataTransform($data));
  }

  /**
   * Update contact.
   * Update contact data.
   *
   * Parameters:
   * $id (int) -- Event id.
   * $data (array) -- Data to be submitted.
   *
   * Example:
   * $data = [
   *     'email' => 'email_modified@example.com',
   *     'companyId' => 3
   * ];
   * $data = $cxfUser->updateEvent(65, $data);
   */
  public function updateEvent($id, $data, $options = []) {
    return $this->client->raw('put', "/customer-data/utilities/events/{$id}", $options, $this->dataTransform($data));
  }

  /**
   * Delete contacts.
   * Delete different contacts.
   *
   * Parameters:
   * $id (mongoId) -- Event id.
   *
   * Example:
   * $id = '5e9c1b8f6b8f6b8f6b8f6b8f';
   * $data = $cxfUser->deleteEvents($id);
   */
  public function deleteEvents($id) {
    return $this->client->raw('delete', "/customer-data/utilities/events/{$id}");
  }
}
