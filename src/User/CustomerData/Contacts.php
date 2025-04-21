<?php

namespace Cxf\User\CustomerData;
use Cxf\CxfHelper;

trait Contacts {
  /**
   * Get contacts.
   * Get a collection of contacts.
   *
   * Parameters:
   * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
   * $usePost (bool) -- Variable to determine if the request is by 'post' or 'get' functions.
   *
   * First Example:
   * $data = $cxfUser->getContacts();
   *
   * Second Example:
   * $options = [
   *   'sort' => 'id',
   *   'fields[contacts]' => 'id, email'
   * ];
   * $data = $cxfUser->getContacts($options);
   *
   * Third Example:
   * $options = [
   *   'sort' => 'id',
   *   'fields[contacts]' => 'id, email'
   * ];
   * $data = $cxfUser->getContacts($options, true);
   */
  public function getContacts($options = [], $usePost = true) {
    return CxfHelper::getQueryResults($this->client,'/customer-data/contacts', $options, $usePost);
  }

  /**
   * Get contact.
   * Get a contact data.
   *
   * Parameters:
   * $id (int) -- Contact id.
   * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
   *
   * First Example:
   * $data = $cxfUser->getContact(5);
   *
   * Second Example:
   * $options = [
   *   'sort' => 'id',
   *   'fields[contacts]' => 'id, email'
   * ];
   * $data = $cxfUser->getContact(5, $options);
   */
  public function getContact($id, $options = []) {
    return $this->client->raw('get', "/customer-data/contacts/{$id}", $options);
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
   * $data = $cxfUser->createContact($data);
   */
  public function createContact($data, $options = []) {
    return $this->client->raw('post', '/customer-data/contacts', $options, $this->dataTransform($data));
  }

  public function findOrCreateContact($data, $options = []) {
    return $this->client->raw('post', '/customer-data/contacts/find-or-create', $options, $this->dataTransform($data));
  }

  /**
   * Update contact.
   * Update contact data.
   *
   * Parameters:
   * $id (int) -- Contact id.
   * $data (array) -- Data to be submitted.
   *
   * Example:
   * $data = [
   *     'email' => 'email_modified@example.com',
   *     'companyId' => 3
   * ];
   * $data = $cxfUser->updateContact(65, $data);
   */
  public function updateContact($id, $data, $options = []) {
    return $this->client->raw('put', "/customer-data/contacts/{$id}", $options, $this->dataTransform($data));
  }

  /**
   * Delete contacts.
   * Delete different contacts.
   *
   * Parameters:
   * $id (mongoId) -- Contact id.
   *
   * Example:
   * $id = '5e9c1b8f6b8f6b8f6b8f6b8f';
   * $data = $cxfUser->deleteContacts($id);
   */
  public function deleteContacts($id) {
    return $this->client->raw('delete', "/customer-data/contacts/{$id}");
  }
}
