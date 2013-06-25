<?php
/**
 * Created by JetBrains PhpStorm.
 * User: digitalwert
 * Date: 21.06.13
 * Time: 13:34
 * To change this template use File | Settings | File Templates.
 */

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\Adapter\GitPhp;


/**
 * Class GitRepository
 *
 * ssh-agent nutzen
 *
 * @see http://stackoverflow.com/questions/4565700/specify-private-ssh-key-to-use-when-executing-shell-command-with-or-without-ruby
 * @see http://stackoverflow.com/questions/2419566/best-way-to-use-multiple-ssh-private-keys-on-one-client
 * @see https://github.com/ccontavalli/ssh-ident/blob/master/ssh-ident
 *
 * @package Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git\Adapter\GitPhp
 */
class GitRepository extends \GitRepo
{
  
    protected $ssh = '/usr/bin/ssh';

    protected $sshKeyFile;


    public function getSsh() {
        return $this->ssh;
    }

    public function getSshKeyFile() {
        return $this->sshKeyFile;
    }

    public function setSsh($ssh) {
        $this->ssh = $ssh;
        return $this;
    }

    public function setSshKeyFile($sshKeyFile) {
        $this->sshKeyFile = $sshKeyFile;
        return $this;
    }
    
    /**
     * 
     * <code>
     *   export  
     *   export
     * </code>
     * 
     * @return array
     */
    protected function getEnv() {
        $env = array();
        
        if($this->getSshKeyFile()) {
            $env['GIT_SSH'] = $this->getSsh();
            $env['PKEY'] = $this->getSshKeyFile();
        }
        
        return $env;
    }

    /**
     * Run a git command in the git repository
     *
     * Accepts a git command to run
     * 
     * <code>
     *  ssh-agent `ssh-add /path/to/file/github.rsa && /usr/bin/git pull /path/to/repo`
     * </code>
     *
     * @access  public
     * @param   string  command to run
     * @return  string
     */
    public function run($command) {
        $command = $this->git_path . ' ' . $command;

//        if($this->isSsh() && $this->getSshKeyFile()){
//            
//           //ssh-agent `ssh-add /var/www/dev.symfony2.monodi/src/app/config/ssh/github.rsa && /usr/bin/git pull /var/www/dev.symfony2.monodi/src/git/tester1` 
//           
//           $command = $this->getSshAgent() . '`' . $this->getSshAdd(). ' ' . $this->getSshKeyFile() . ' &&  ' . $command . '`';
//        }
        return $this->run_command($command);
    }
    
    /**
     * Run a command in the git repository
     *
     * Accepts a shell command to run
     *
     * @access  protected
     * @param   string  command to run
     * @return  string
     */
    protected function run_command($command) {
        $descriptorspec = array(
            1 => array('pipe', 'w'),
            2 => array('pipe', 'w'),
        );
        $pipes = array();
        $resource = proc_open(
            $command,
            $descriptorspec, 
            $pipes, 
            $this->repo_path,
            $this->getEnv()
        );

        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        foreach ($pipes as $pipe) {
            fclose($pipe);
        }

        $status = trim(proc_close($resource));
        if ($status)
            throw new GitException($stderr);

        return $stdout;
    }


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
    public static function &create_new($repo_path, $source = null, $bare = false, $shared = false) {

        if (is_dir($repo_path) && ((file_exists($repo_path."/.git") && is_dir($repo_path."/.git")) || (file_exists($repo_path."/HEAD") && is_dir($repo_path."/objects")))) {
            throw new Exception("'$repo_path' is already a git repository");
        } else {
            $shared = (trim($shared));

            // Sanity check the shared option
            if(!preg_match('/^(true)|(umask)|(group)|(all)|(world)|(everybody)|(0\d{3})$/', $shared)) {
                $shared = false;
            }

            $repo = new self($repo_path, true, false, $bare);
            if (is_string($source)) {
                $repo->clone_from($source);
            } else {
                $args = '';
                if($bare)
                    $args .= ' --bare';

                if($shared)
                    $args .= " --shared=$shared";

                $repo->run("init $args");
            }
            return $repo;
        }
    }

    /**
     * Constructor
     *
     * Accepts a repository path
     *
     * @access  public
     * @param   string  repository path
     * @param   bool    create if not exists?
     * @param   bool    is the repo a bare one?
     * @return  void
     */
    public function __construct($repo_path = null, $create_new = false, $_init = true, $bare = false) {
        if (is_string($repo_path))
            $this->set_repo_path($repo_path, $create_new, $_init, $bare);
    }
}