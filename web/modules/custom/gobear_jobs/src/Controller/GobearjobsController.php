<?php

namespace Drupal\gobear_jobs\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\Client;

/**
 * Class GobearjobsController.
 */
class GobearjobsController extends ControllerBase {

  /**
   * GuzzleHttp\Client definition.
   *
   * @var \GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * Constructs a new GobearjobsController object.
   */
  public function __construct(Client $http_client) {
    $this->httpClient = $http_client;
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('http_client')
    );
  }

  /**
   * Joblisting.
   *
   * @return string
   *   Return Hello string.
   */
  public function jobListing() {
    // $request = $this->httpClient->createRequest('GET', 'https://jobs.github.com/positions.json?location=new+york');
    // $request->addHeader('If-Modified-Since', gmdate(DATE_RFC1123, $last_fetched));.
    $data = NULL;
    try {
      $response = $this->httpClient->get('https://jobs.github.com/positions.json?location=new+york', [
        'headers' => [
          'Accept' => 'application/json',
        ],
      ]);
      // Expected result.
      // getBody() returns an instance of Psr\Http\Message\StreamInterface.
      // @see http://docs.guzzlephp.org/en/latest/psr7.html#body
      $data = $response->getBody()->getContents();
      // Echo '<pre>';.
      $decoded = (isset($data)) ? json_decode($data) : NULL;
      $output = NULL;
      if ($decoded) {
        foreach ($decoded as $key => $val) {
          $output .= '<div>title=' . $val->title . '</div>';
          $output .= '<div>company=' . $val->company . '</div>';
          $output .= '<div>location=' . $val->location . '</div>';
          $output .= '<div>type=' . $val->type . '</div>';
          $output .= '<div>created_at=' . $val->created_at . '</div>';
        }
      }

      return [
        '#type' => 'markup',
        '#markup' => $output,
      ];
    }
    catch (RequestException $e) {
      watchdog_exception('my_module', $e);
    }
  }

}
