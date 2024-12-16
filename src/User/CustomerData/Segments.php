<?php
namespace Cxf\User\CustomerData;
trait Segments {

  /**
   * Get segments support data.
   *
   * Example:
   * $data = $cxfUser->getSegmentsSupportData();
   */
  public function getSegmentsSupportData() {
    return $this->client->raw('get', '/customer-data/segments/support-data');
  }

  /**
   * Get segments attributes.
   *
   * Parameters:
   * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
   *
   * Example:
   * $options = ['object_type' => 'contacts'];
   * $data = $cxfUser->getSegmentsAttributes($options);
   */
  public function getSegmentsAttributes($options = null) {
    return $this->client->raw('get', '/customer-data/segments/attributes', $options);
  }

  /**
   * Get segment group.
   *
   * Parameters:
   * $groupId (string) -- Group's name.
   *
   * Example:
   * $data = $cxfUser->getSegmentGroup("users");
   */
  public function getSegmentGroup($groupId) {
    return $this->client->raw('get', "/customer-data/segments/groups/{$groupId}");
  }

  /**
   * Duplicate segment.
   *
   * Parameters:
   * $id (int) -- Segment id.
   * $data (array) -- Data to be submitted.
   *
   * Example:
   * $data = ['options' => []];
   * $data = $cxfUser->duplicateSegment(107, $data);
   */
  public function duplicateSegment($id, $data) {
    return $this->client->raw('post', "/customer-data/segments/{$id}/duplicate", null, $data);
  }

  /**
   * Get segments.
   *
   * Parameters:
   * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
   *
   * First Example:
   * $data = $cxfUser->getSegments();
   *
   * Second Example:
   * $options = ['fields' => 'id', 'sort' => '-id'];
   * $data = $cxfUser->getSegments($options);
   */
  public function getSegments($options = null) {
    return $this->client->raw('get', '/customer-data/segments', $options);
  }

  /**
   * Get segment.
   *
   * Parameters:
   * $id (int) -- Segment id.
   * $options (array) -- List of Resource Collection Options shown above can be used as parameter.
   *
   * First Example:
   * $data = $cxfUser->getSegment(1);
   *
   * Second Example:
   * $options = ['fields' => 'id, title'];
   * $data = $cxfUser->getSegment(1, $options);
   */
  public function getSegment($id, $options = null) {
    return $this->client->raw('get', "/customer-data/segments/{$id}", $options);
  }

  /**
   * Create segment.
   *
   * Parameters:
   * $data (array) -- Data to be submitted.
   *
   * Example:
   * $data = [
   *     'title' => 'New Segment',
   *     'object_type' => 'deals'
   * ];
   * $data = $cxfUser->createSegment($data);
   */
  public function createSegment($data) {
    return $this->client->raw('post', '/customer-data/segments', null, $this->dataTransform($data));
  }

  /**
   * Update segment.
   *
   * Parameters:
   * $id (int) -- Segment id.
   * $data (array) -- Data to be submitted.
   *
   * Example:
   * $data = ['title' => 'New Segment Modified'];
   * $data = $cxfUser->updateSegment(118, $data);
   */
  public function updateSegment($id, $data) {
    return $this->client->raw('put', "/customer-data/segments/{$id}", null, $this->dataTransform($data));
  }

  /**
   * Delete segment.
   *
   * Parameters:
   * $id (int) -- Segment id.
   *
   * Example:
   * $cxfUser->deleteSegment(113);
   */
  public function deleteSegment($id) {
    return $this->client->raw('delete', "/customer-data/segments/{$id}");
  }
}
