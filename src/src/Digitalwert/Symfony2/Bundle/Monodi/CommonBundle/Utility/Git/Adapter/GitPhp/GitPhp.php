<?php
/**
 * Created by JetBrains PhpStorm.
 * User: digitalwert
 * Date: 21.06.13
 * Time: 13:32
 * To change this template use File | Settings | File Templates.
 */

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\Adapter\GitPhp;


/**
 * Class GitPhp
 *
 * @package Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\Adapter\GitPhp
 */
class GitPhp extends \Git
{

    /**
     * Create a new git repository
     *
     * Accepts a creation path, and, optionally, a source path
     *
     * @access  public
     * @param   string  repository path
     * @param   string  directory to source
     * @param   bool    is the repo a bare one?
     * @param   string  the 'shared' option as per git init - (false|true|umask|group|all|world|everybody|0xxx)
     * @return  GitRepo
     */
    public static function &create($repo_path, $source = null, $bare = false, $shared = false) {
        return GitRepository::create_new($repo_path, $source, $bare, $shared);
    }

    /**
     * Open an existing git repository
     *
     * Accepts a repository path
     *
     * @access  public
     * @param   string  repository path
     * @return  GitRepo
     */
    public static function open($repo_path) {
        return new GitRepository($repo_path);
    }

    /**
     * Checks if a variable is an instance of GitRepo
     *
     * Accepts a variable
     *
     * @access  public
     * @param   mixed   variable
     * @return  bool
     */
    public static function is_repo($var) {
        if($var instanceof \GitRepo) {
            return true;
        }
        return false;
    }
}