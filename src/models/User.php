<?php

namespace yiisolutions\user\models;

use Yii;
use yii\base\ModelEvent;
use yii\base\NotSupportedException;
use yii\behaviors\AttributeBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_NEW = 'NEW';
    const STATUS_ACTIVATED = 'ACTIVATED';
    const STATUS_DELETED = 'DELETED';

    const STATUS_ALL = [
        self::STATUS_NEW,
        self::STATUS_ACTIVATED,
        self::STATUS_DELETED,
    ];

    public $password_raw;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'auth_key', 'password_hash', 'email'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['auth_key', 'status'], 'string', 'max' => 32],
            [['auth_key'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['status'], 'in', 'range' => self::STATUS_ALL],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
                'value' => new Expression('NOW()'),
            ],
            'authKey' => [
                'class' => AttributeBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_VALIDATE => 'auth_key',
                ],
                'value' => function(ModelEvent $modelEvent) {
                    if (empty($modelEvent->sender->auth_key)) {
                        $modelEvent->sender->auth_key = self::generateAuthKey();
                    }
                }
            ],
        ];
    }

    /**
     * @param $password
     * @return string
     */
    public static function generatePasswordHash($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * @return string
     */
    public static function generateAuthKey()
    {
        return Yii::$app->security->generateRandomString();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne([
            'id' => $id,
            'status' => static::STATUS_ACTIVATED,
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }
}
