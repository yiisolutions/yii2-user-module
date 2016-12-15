<?php

namespace yiisolutions\user\commands;

use Yii;
use yii\console\Controller;
use yii\helpers\Console;
use yiisolutions\user\models\User;

/**
 * User module commands.
 */
class CommandsController extends Controller
{
    /**
     * @var string username. Use these option if don't interactive mode (--interactive=0).
     */
    public $username;

    /**
     * @var string user email address. Use these option if don't interactive mode (--interactive=0).
     */
    public $email;

    /**
     * @var string password for user. Use these option if don't interactive mode (--interactive=0).
     */
    public $password;

    public function options($actionID)
    {
        $options = parent::options($actionID);

        switch ($actionID) {
            case 'create':
                $options[] = 'username';
                $options[] = 'email';
                $options[] = 'password';
                break;
        }

        return $options;
    }

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (!parent::beforeAction($action)) {
            return false;
        }

        $this->stdout("\nYii Solutions User Module version 1.0.0\n");

        return true;
    }

    /**
     * Create new user.
     *
     * @return int
     */
    public function actionCreate()
    {
        $this->stdout("\nCreate user\n", Console::BOLD);

        $model = new User();
        $model->scenario = User::SCENARIO_COMMAND_CREATE;

        if ($this->interactive) {
            $this->stdout("\nPlease fill required fields\n");

            $model->username = $this->promptAttribute($model, 'username');
            $model->email = $this->promptAttribute($model, 'email');
            $model->password = $this->promptAttribute($model, 'password');
        } else {
            $model->username = $this->username;
            $model->email = $this->email;
            $model->password = $this->password;

            if (!$model->validate()) {
                $this->stderr("\nValidation errors\n", Console::BOLD);

                foreach ($model->getFirstErrors() as $attribute => $error) {
                    $this->stderr("\n    - " . $model->getAttributeLabel($attribute) . ": ", Console::FG_GREEN);
                    $this->stderr($error . "\n", Console::FG_RED);
                }

                return self::EXIT_CODE_ERROR;
            }
        }

        if ($model->save()) {
            $this->stdout("\nUser {$model->username} created successful. New user ID {$model->id}.\n", Console::BOLD);

            return self::EXIT_CODE_NORMAL;
        } else {
            $this->stderr("\nUser created error\n", Console::FG_RED, Console::BOLD);

            return self::EXIT_CODE_ERROR;
        }
    }

    /**
     * Truncate all users
     *
     * @return int
     */
    public function actionTruncate()
    {
        $this->stdout("\nTruncate users\n", Console::BOLD);

        if (!$this->interactive || $this->confirm(Console::ansiFormat("Warning! These operation not be revert! Are you sure?", [Console::FG_YELLOW]))) {
            $count = Yii::$app->db->createCommand()
                ->truncateTable(User::tableName())
                ->execute();

            $this->stdout("\n{$count} records are be truncated\n");
        } else {
            $this->stdout("\nAbort operation!\n");
        }

        return self::EXIT_CODE_NORMAL;
    }

    /**
     * Prompt attribute helper method
     * @param User $model
     * @param $attribute
     * @param bool $required
     *
     * @return string
     */
    private function promptAttribute(User $model, $attribute, $required = true)
    {
        return $this->prompt("\n    - " . Console::ansiFormat($model->getAttributeLabel($attribute), [Console::FG_GREEN]) . ": ", [
            'required' => $required,
            'validator' => function($input, &$error) use ($model, $attribute) {
                $model->$attribute = $input;
                $model->validate([$attribute]);
                if ($model->hasErrors($attribute)) {
                    $error = "\n    " . Console::ansiFormat($model->getFirstError($attribute), [Console::FG_RED]);
                    return false;
                }
                return true;
            },
        ]);
    }
}
