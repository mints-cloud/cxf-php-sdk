<?php

namespace Cxf\User\CustomerData;
use Cxf\CxfHelper;

trait Companies {

  /**
   * Get companies support data.
   * Get support data of companies.
   *
   * Example:
   * $data = $cxfUser->getCompaniesSupportData();
   */
  public function getCompaniesSupportData() {
    return $this->client->raw('get', '/customer-data/companies/support-data');
  }

  /**
   * Get companies.
   * Get a collection of companies.
   *
   * Parameters:
   * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
   * $usePost (bool) -- Variable to determine if the request is by 'post' or 'get' functions.
   *
   * First Example:
   * $data = $cxfUser->getCompanies();
   *
   * Second Example:
   * $options = ['fields' => 'id, title', 'sort' => '-id'];
   * $data = $cxfUser->getCompanies($options);
   *
   * Third Example:
   * $options = ['fields' => 'id, title', 'sort' => '-id'];
   * $data = $cxfUser->getCompanies($options, false);
   */
  public function getCompanies($options = [], $usePost = true) {
    return CxfHelper::getQueryResults($this->client, '/customer-data/companies', $options, $usePost);
  }

  /**
   * Get company.
   * Get a company info.
   *
   * Parameters:
   * $id (int) -- Company id.
   * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
   *
   * First Example:
   * $data = $cxfUser->getCompany(21);
   *
   * Second Example:
   * $options = ['fields' => 'id, title'];
   * $data = $cxfUser->getCompany(21, $options);
   */
  public function getCompany($id, $options = []) {
    return $this->client->raw('get', "/customer-data/companies/{$id}", $options);
  }

  /**
   * Create company.
   * Create a company with data.
   *
   * Parameters:
   * $data (array) -- Data to be submitted.
   *
   * Example:
   * $data = [
   *     'title' => 'Company Title',
   *     'alias' => 'Alias',
   *     'website' => 'www.company.example.com',
   *     'street1' => 'Company St',
   *     'city' => 'Company City',
   *     'region' => 'Company Region',
   *     'postal_code' => '12345',
   *     'country_id' => 144,
   *     'tax_identifier' => null
   * ];
   * $data = $cxfUser->createCompany($data);
   */
  public function createCompany($data, $options = []) {
    return $this->client->raw('post', '/customer-data/companies/', $options, $this->dataTransform($data));
  }

  /**
   * Update company.
   * Update a company info.
   *
   * Parameters:
   * $id (int) -- Company id.
   * $data (array) -- Data to be submitted.
   *
   * Example:
   * $data = [
   *     'title' => 'Company Title Modified'
   * ];
   * $data = $cxfUser->updateCompany(23, $data);
   */
  public function updateCompany($id, $data, $options = []) {
    return $this->client->raw('put', "/customer-data/companies/{$id}", $options, $this->dataTransform($data));
  }

  /**
   * Delete Companies.
   * Delete a group of companies.
   *
   * Parameters:
   * $data (array) -- Data to be submitted.
   *
   * Example:
   * $data = ['ids' => ['21', '22']];
   * $data = $cxfUser->deleteCompanies($data);
   */
  public function deleteCompanies($data) {
    return $this->client->raw('delete', '/customer-data/companies/delete', null, $this->dataTransform($data));
  }
}
