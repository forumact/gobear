<?php

namespace Drupal\gobear_jobs\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\Client;
 
/**
 * Class GobearjobsController.
 */
class GobearjobsController extends ControllerBase
{

    /**
   * GuzzleHttp\Client definition.
   *
   * @var \GuzzleHttp\Client
   */
    protected $httpClient;

    /**
   * Constructs a new GobearjobsController object.
   */
    public function __construct(Client $http_client) 
    {
        $this->httpClient = $http_client;
    }

    /**
   * {@inheritdoc}
   */
    public static function create(ContainerInterface $container) 
    {
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
    public function jobListing() 
    {
        $data = null;
        try {
            $response = $this->httpClient->get(
                'https://jobs.github.com/positions.json?location=new+york', [
                'headers' => [
                'Accept' => 'application/json',
                ],
                ]
            );
            // Expected result.
            // getBody() returns an instance of Psr\Http\Message\StreamInterface.
            // @see http://docs.guzzlephp.org/en/latest/psr7.html#body
            $data = $response->getBody()->getContents();
      
      
            $decoded = (isset($data)) ? json_decode($data) : null;
            return [
            '#theme' => 'gobear_jobs',
            '#data' => $decoded,        
            ];
        }
        catch (RequestException $e) {
            watchdog_exception('Gobearjobs', $e);
        }
    }

}
