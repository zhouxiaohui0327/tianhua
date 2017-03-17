<?php
/**
 * Created by PhpStorm.
 * User: cgeek
 * Date: 5/29/16
 * Time: 11:00 PM
 */

use Sunra\PhpSimple\HtmlDomParser;

class MainTask extends \Phalcon\CLI\Task
{
    public function mainAction()
    {
        echo "\nThis is the default task and the default action \n";
    }
}
