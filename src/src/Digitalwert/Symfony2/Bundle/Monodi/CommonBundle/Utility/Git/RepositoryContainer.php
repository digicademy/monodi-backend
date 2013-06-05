<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Digitalwert\Symfony2\Bundle\Monodi\CommonBundle\Utility\Git;

/**
 * Interface für die Verwaltung von Repositories
 * 
 * @author digitalwert
 */
interface RepositoryContainer 
{
    /**
     * @return string user.email
     */
    public function getEmail();
    
    /**
     * @return string user.name
     */
    public function getDisplayName();
    
    /**
     * der Reposetory-Entity
     */
    public function getRepository();
    
    /**
     * Gibt den Pfad zum Repository zurück
     * 
     * @see ::getPath();
     * 
     * @return string
     */
    public function getRepositoryPath();
}