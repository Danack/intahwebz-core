<?php
namespace Intahwebz;

interface Session {


    public function initSession();

    public function setSessionVariable($sessionName, $serializedData);

    public function getSessionVariable($name, $default = false, $clear = false);

    public function unsetSessionVariable($sessionName);

    //TODO - this should not be in here.
    public function logoutUser();
}