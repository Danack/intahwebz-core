<?php

namespace Intahwebz\Controller;


use Intahwebz\ViewModel;
use Intahwebz\Response;


class Controller{

    use \Intahwebz\SafeAccess;

    /**
     * @var ViewModel
     */
    var $viewModel = null;

    /**
     * @var \Intahwebz\Response
     */
    public $response = null;

    public function getResponse() {
        return $this->response;
    }

    public function getViewModel() {
        return $this->viewModel;
    }

    function init(ViewModel $viewModel, Response $response) {
        $this->viewModel = $viewModel;
        $this->response = $response;
    }
}

