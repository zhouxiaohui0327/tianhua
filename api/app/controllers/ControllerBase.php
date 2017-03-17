<?php

use Phalcon\Mvc\Controller;
use Phalcon\Cache\Backend\File as BackFile;
use Phalcon\Cache\Frontend\Data as FrontData;

class ControllerBase extends Controller
{
	private $appId = 'wx59927c8be8811abb';
	private $appSecret = 'a53e1d32323695e9f2b69093a53094e2';

    public $auth = null;

    protected function initialize()
    {
        $this->view->setTemplateAfter('main');
    }


    /**
     *
     * json结果返回
     *
     * @param bool $success
     * @param string $message
     * @param array $data
     * @return mixed
     */
    public function jsonResponse($code = '200', $message = '', $data = array())
    {
        $this->view->disable();

        $this->response->setContentType('application/json', 'UTF-8');

        $result = array('code' => $code, 'message' => $message, 'data' => $data);
        $this->response->setJsonContent($result);

        $this->response->send();

        die();

    }
}
