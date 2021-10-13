<?php

namespace app\models;

class UpdateForm extends \yii\base\Model
{
    public $id;
    public $title;
    public $text;

    public function __construct($id = '', $config = [])
    {
        $this->id = $id;
        parent::__construct($config);
    }
}