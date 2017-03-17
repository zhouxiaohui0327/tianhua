<?php

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class IndexController extends ControllerBase
{
    public $qiniuAccessKey = 'F2uQBFs5CZGqThIchwWmN6JfmAdq88aQnNV4GmOl';
    public $qiniuSecretKey = 'jpGMJCXq-pfI_TO9hCrWbgfoPLd-qt9kb_zii3wy';


    public $login_user_id = 0;

    protected function initialize()
    {
        parent::initialize();
    }


    /**
     * 首页
     */

    public function indexAction()
    {
        $pic_lists = Picture::find("status >= 0 LIMIT 0,5");
        $this->view->setVar('pic_lists',$pic_lists);
    }

    public function introduceAction()
    {
        $pic_lists = Picture::find("status >= 0 LIMIT 0,5");
        $this->view->setVar('pic_lists',$pic_lists);
    }

    public function patternAction()
    {
        $pic_lists = Picture::find("status >= 0 LIMIT 0,5");
        $this->view->setVar('pic_lists',$pic_lists);
    }

    public function productAction()
    {
        $page = $this->request->has('page') ? $this->request->get('page') : 1 ;
        $page = $page == 0 ? 1 : $page;
        $limit = 8;
        $startCount = ($page - 1) * $limit;

        $product = Picture::count("status >= 0");
        $products = Picture::find("status >= 0 ORDER BY id desc LIMIT $startCount ,$limit");
        $this->view->setVar('products',$products);

        $totalNumber = $product;
        $totalPage = ceil($totalNumber/$limit);

        $this->view->setVar('totalNumber',$totalNumber);
        $this->view->setVar('totalPage',$totalPage);
        $this->view->setVar('page',$page);

        $pic_lists = Picture::find("status >= 0 LIMIT 0,5");
        $this->view->setVar('pic_lists',$pic_lists);
        $b = 3 ;
        $this->view->setVar('b',$b);
    }

    public function contactAction()
    {
        $pic_lists = Picture::find("status >= 0 LIMIT 0,5");
        $this->view->setVar('pic_lists',$pic_lists);
    }




}
