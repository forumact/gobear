<?php

namespace Drupal\gobear_jobs\TwigExtension;


/**
 * Class TimeSinceExtension.
 */
class TimeSinceExtension extends \Twig_Extension
{

        
    /**
    * {@inheritdoc}
    */
    public function getTokenParsers() 
    {
        return [];
    }

    /**
    * {@inheritdoc}
    */
    public function getNodeVisitors() 
    {
        return [];
    }

    /**
    * {@inheritdoc}
    */
    public function getFilters() 
    {
        return [
        new \Twig_SimpleFilter('timesince', array($this, 'timeSince')),
        ];
    }

    /**
    * {@inheritdoc}
    */
    public function getTests() 
    {
        return [];
    }

    /**
    * {@inheritdoc}
    */
    public function getFunctions() 
    {
        return [];
    }

    /**
    * {@inheritdoc}
    */
    public function getOperators() 
    {
        return [];
    }

    /**
    * {@inheritdoc}
    */
    public function getName() 
    {
        return 'gobear_jobs.twig.timesince';
    }
    
    /**
    * Gets a unique identifier for this Twig extension.
    */   
    public function timeSince($time) 
    {
         $etime = time() - strtotime($time);

        if ($etime < 1) {
            return '0 seconds';
        }

          $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
          $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
                );

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }

    }
}
