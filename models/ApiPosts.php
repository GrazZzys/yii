<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

    class ApiPosts extends ActiveRecord
{
   public static function tableName()
   {
       return '{{posts}}';
   }
}