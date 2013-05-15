<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Tests\Utility\Git;

use \Symfony\Component\Filesystem\Filesystem;

/**
 * Git2Test überprüft das händling mit Git2
 *
 * @author digitalwert
 * @see https://github.com/libgit2/php-git
 */
class Git2Test extends \PHPUnit_Framework_TestCase
{
    /**
     * Pfad zur Repository
     * @var string
     */
    static protected $path;
    
    /**
     * Dateisystemhelper
     * @var \Symfony\Component\Filesystem\Filesystem
     */
    static protected $filesystem;

    static public function setUpBeforeClass() {
        self::$path = __DIR__ . '/temp';
        
        self::$filesystem = new Filesystem();
        
        self::$filesystem->mkdir(self::$path);       
    }
    
    /**
     * Prüft ob neues Reposetory angelegt werden kann
     */
    public function testInitRepos() {

       $this->assertTrue(self::$filesystem->exists(self::$path));
       
       $repo = \Git2\Repository::init(self::$path, false);
       
       $this->assertTrue($repo->isEmpty());
//       var_dump(\Git2\Repository::discover($this->path));
//       var_dump($repo->getPath());
       
       $this->assertEquals(self::$path . '/.git/', $repo->getPath());
       $this->assertEquals(\Git2\Repository::discover(self::$path), $repo->getPath());
    }
    
    /**
     * 
     * @depends testInitRepos

     * @test
     */
    public function testAdd() {
        $repo = new \Git2\Repository(self::$path);
        
        var_dump($repo);
    }
    
    /**
     * Aufräumen nach test
     */
    static public function tearDownAfterClass() {
        self::$filesystem->remove(self::$path);
    }
}

