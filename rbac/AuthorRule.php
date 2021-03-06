<?php

namespace app\rbac;

use Yii;
use yii\rbac\Item;
use yii\rbac\Rule;
use app\models\Posts;

class AuthorRule extends Rule
{
    public $name = 'isAuthor';

    /**
     * @param string|int $user the user ID.
     * @param Item $item the role or permission that this rule is associated with
     * @param array $params parameters passed to ManagerInterface::checkAccess().
     * @return bool a value indicating whether the rule permits the role or permission it is associated with.
     */
    public function execute($user, $item, $params)
    {
        $author = $params['post']['author'];
        return isset($params['post']) && $author == $user;
    }
}