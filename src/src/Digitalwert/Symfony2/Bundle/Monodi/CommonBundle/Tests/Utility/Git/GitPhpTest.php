<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Tests\Utility\Git;

use \Symfony\Component\Filesystem\Filesystem;
/**
 * GitPhpTest überprüft die Funktionalität von Git.php
 *
 * @author digitalwert
 * @see https://github.com/pwhittlesea/Git.php.git
 * 
 */
class GitPhpTest extends \PHPUnit_Framework_TestCase
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
    
    /**
     * 
     */
    static public function setUpBeforeClass() {
        self::$path = __DIR__ . '/temp';
        
        self::$filesystem = new Filesystem();
        
        self::$filesystem->mkdir(self::$path);       
    }
    
    /**
     * 
     * @test
     */
    public function testInitRepo() {
        
        $this->assertTrue(self::$filesystem->exists(self::$path));
        
        $repo = \Git::create(self::$path);
        $this->assertTrue(\Git::is_repo($repo));
        $this->assertTrue($repo->test_git());
        
        $repo->run('config user.name "Test Tester"');
        $repo->run('config user.email "git@test.digitalwert.de"');
        
        $this->assertEquals("Test Tester\n", $repo->run('config user.name'));
        $this->assertEquals("git@test.digitalwert.de\n", $repo->run('config user.email'));      
    }
       
    /**
     * TEst das hinzufügen eines remotes
     * @depends testInitRepo
     * @test
     */
    public function remote() {
        $repo = \Git::open(self::$path);        
        $this->assertTrue(\Git::is_repo($repo));
        
        $url = 'git@github.com:mischka/monodi-test.git';
        $repo->run('remote add origin ' . $url);
        $remote = $repo->run('remote -v');
        
        $this->assertEquals(
          "origin\t" . $url . " (fetch)\norigin\t" . $url . " (push)\n",
          $remote
        );
    }
    
    /**
     * Aktualisieren vom Remote zum Loklalenl
     * 
     * @depends remote
     * test 
     */
    public function fetch() {
        $repo = \Git::open(self::$path);        
        $this->assertTrue(\Git::is_repo($repo));
        
        var_dump($repo->run('fetch'));
    }
    
    /**
     * 
     * @depends remote
     * @test
     */
    public function pull() {
        $repo = \Git::open(self::$path);        
        $this->assertTrue(\Git::is_repo($repo));
        
        var_dump($repo->run('pull -v origin master'));
    }
    
    /**
     * 
     * @depends pull
     * @test
     */
    public function add() {
        $repo = \Git::open(self::$path);
        
        $this->assertTrue(\Git::is_repo($repo));
        
        // Schreibe dateien in das Repo
        self::$filesystem->mkdir(self::$path . '/test1');
        self::$filesystem->mkdir(self::$path . '/test2/test2/bar/buz');
        
        $readme = new \SplFileObject(self::$path . '/readme.txt', 'w');
        $readme->fwrite('Dies ist zu Testzwecken');
        
        $fooContent = '<xml>sadfasdfdsaf' . time() . '</xml>';
        
        $foo = new \SplFileObject(self::$path . '/test2/test2/bar/buz/foo.xml', 'w');
        $foo->fwrite($fooContent);   
        
        $status = $repo->run('status -s');
        var_dump($status);
        
        $res = $repo->add(
          array(
            $foo->getPathname(),
            $readme->getPathname(),  
          )
        );
        
        
        // $status => " M readme.txt\n M test2/test2/bar/buz/foo.xml\n"
        
        var_dump($res);
        //$this->assertEquals("add 'readme.txt'\nadd 'test2/test2/bar/buz/foo.xml'\n", $res);
        
        return array($readme, $foo);
    }
    
    /**
     * 
     * @depends add
     * @test
     */
    public function commit($files) {
        $repo = \Git::open(self::$path);        
        $this->assertTrue(\Git::is_repo($repo));
        
        var_dump($repo->commit("initaler Testcommit"));
    }
    
    /**
     * 
     * @depends commit
     * @test
     */
    public function push() {
        $repo = \Git::open(self::$path);        
        $this->assertTrue(\Git::is_repo($repo));
        
        //
        // git remote add origin https://digitalwert@bitbucket.org/digitalwert/monodi-test.git
        // git push -u origin --all   # to push up the repo for the first time
        // git push -u origin master
        
        var_dump($repo->run('push -u origin'));
        
        //"Branch master set up to track remote branch master from origin.\n"
    }    
    
    
    /**
     * Erstelle ein Tag für die Aktuelle version
     * 
     * @depends push
     * @test
     */
    public function tag() {
        $tag = time();
        
        $repo = \Git::open(self::$path);        
        $this->assertTrue(\Git::is_repo($repo));
        
        var_dump($repo->run('tag -a '. $tag.' -m "Test TAG"'));
        var_dump($repo->run('tag -l'));
    }

        /**
     * Aufräumen nach test
     */
    static public function tearDownAfterClass() {
        self::$filesystem->remove(self::$path);
    }
}