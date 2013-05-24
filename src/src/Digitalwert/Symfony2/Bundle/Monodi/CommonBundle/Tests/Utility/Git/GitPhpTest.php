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
     * 
     * @depends testInitRepo
     * @test
     */
    public function testAdd() {
        $repo = \Git::open(self::$path);
        
        $this->assertTrue(\Git::is_repo($repo));
        
        // Schreibe dateien in das Repo
        self::$filesystem->mkdir(self::$path . '/test1');
        self::$filesystem->mkdir(self::$path . '/test2/test2/bar/buz');
        
        $readme = new \SplFileObject(self::$path . '/readme.txt', 'w');
        $readme->fwrite('Dies ist zu Testzwecken');
        
        $foo = new \SplFileObject(self::$path . '/test2/test2/bar/buz/foo.xml', 'w');
        $foo->fwrite('<xml>sadfasdfdsaf</xml>');        
        
        $res = $repo->add();
        
        $this->assertEquals("add 'readme.txt'\nadd 'test2/test2/bar/buz/foo.xml'\n", $res);
        
        return array($readme, $foo);
    }
    
    /**
     * 
     * @depends testAdd
     * @test
     */
    public function testCommit($files) {
        $repo = \Git::open(self::$path);        
        $this->assertTrue(\Git::is_repo($repo));
        
        var_dump($repo->commit("initaler Testcommit"));
    }
    
    /**
     * 
     * @depends testCommit
     * @test
     */
    public function testPush() {
        $repo = \Git::open(self::$path);        
        $this->assertTrue(\Git::is_repo($repo));
        
        $url = 'git@github.com:mischka/monodi-test.git';
        $repo->run('remote add origin ' . $url);
        $remote = $repo->run('remote -v');
        
        $this->assertEquals(
          "origin\t" . $url . " (fetch)\norigin\t" . $url . " (push)\n",
          $remote
        );
        
        //
        // git remote add origin https://digitalwert@bitbucket.org/digitalwert/monodi-test.git
        // git push -u origin --all   # to push up the repo for the first time
        // git push -u origin master
        
        var_dump($repo->run('push -u origin'));
        
        //"Branch master set up to track remote branch master from origin.\n"
    }
    
    /**
     * Aktualisieren vom Remote zum Loklalenl
     */
    public function testFetch() {
//        $repo = \Git::open(self::$path);        
//        $this->assertTrue(\Git::is_repo($repo));
//        
//        $repo->run('fetch');
    } 


    /**
     * Aufräumen nach test
     */
    static public function tearDownAfterClass() {
        //self::$filesystem->remove(self::$path);
    }
}