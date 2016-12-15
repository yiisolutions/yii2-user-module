<?php

namespace yiisolutions\user\actions;

use yii\base\Action;

class SignUpAction extends Action
{
    public $viewName = '@yiisolutions/user/views/sign-up';

    public function run()
    {
        return $this->controller->render($this->viewName, [

        ]);
    }
}
