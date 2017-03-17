<?php

class Picture extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     */
    public $id;

    /**
     *
     * @var string
     */
    public $pic;

    /**
     *
     * @var string
     */
    public $last_time;

    /**
     *
     * @var integer
     */
    public $status;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
//        $this->belongsTo('uid', 'User', 'id', array('alias' => 'User'));
    }



    /**
     * Independent Column Mapping.
     */
    public function columnMap()
    {
        return array(
            'id' => 'id', 
            'pic' => 'pic',
            'last_time' => 'last_time',
            'status' => 'status',
        );
    }

}
