<?php

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git;

/**
 * 
 */
interface GitInterface
{
    public function add();
    
    public function commit($message);
    
    public function setConfig();
    
    public function getConfig();    
    
    public function create();
    
    public function diff();
    
    public function status();
    
    public function log();

    public function push();
    
    public function pull();
            
}
