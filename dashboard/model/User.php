<?php
class User
{
    private $id;
    private $username;

    private $passwordHash;

    private $spotifyFeatureEnabled;

    function __construct($id, $username,$passwordHash,$spotifyFeatureEnabled)
    {
        $this->id = $id;
        $this->username = $username;
        $this->passwordHash = $passwordHash;
        $this->spotifyFeatureEnabled = $spotifyFeatureEnabled;
    }

    function getId()
    {
        return $this->id;
    }

    function getUsername()
    {
        return $this->username;
    }

    function getPasswordHash(){
        return $this->passwordHash;
    }

    function isSpotifyFeatureEnabled(){
        return $this->spotifyFeatureEnabled;
    }

}

?>