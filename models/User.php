<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User ActiveRecord model
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property int $created_at
 * @property int $updated_at
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $confirm_password;
    private $_oldPasswordHash;
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    public function rules(): array
    {
        return [
            [['name', 'email'], 'required'],
            ['email', 'email'],
            [
                'email',
                'unique',
                'targetClass' => self::class,
                'message' => 'This email address has already been taken.',
                'on' => ['create', 'update'],
                'filter' => function ($query) {
                    if (!$this->isNewRecord) {
                        $query->andWhere(['<>', 'id', (int)$this->id]);
                    }
                },
            ],
            [['created_at', 'updated_at'], 'integer'],

            // Password rules (on create or on update when filled)
            [['password', 'confirm_password'], 'required', 'on' => 'create'],
            [['password', 'confirm_password'], 'safe', 'on' => 'update'],
            ['password', 'string', 'min' => 5],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'skipOnEmpty' => true,],
        ];
    }

    /*
     * Password handling
     **/

    public function setPassword(string $password): void
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    public function validatePassword(string $password): bool
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /*
     * IdentityInterface (DB-backed)
     **/

    public static function findIdentity($id): ?self
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null; // not using
    }

    public static function findByEmail(string $email): ?self
    {
        return static::findOne(['email' => $email]);
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return null;
    }

    public function validateAuthKey($authKey): bool
    {
        return true;
    }

    /*
     * Timestamps
     **/

    public function beforeSave($insert): bool
    {
        if ($insert) {
            $this->created_at = time();
        }

        $this->updated_at = time();

        // Handle password change on update
        if($this->scenario === 'update') {
            if(!empty($this->password)) {
                $this->password = Yii::$app->security
                ->generatePasswordHash($this->password);
            }else {
                // No new password → keep old hash
                $this->password = $this->_oldPasswordHash;
            }
        }
        return parent::beforeSave($insert);
    }

    public function afterFind()
    {
        parent::afterFind();

        // Store existing password hash
        $this->_oldPasswordHash = $this->password;
    }


    // Scenarios
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['create'] = ['name', 'email', 'password', 'confirm_password'];
        $scenarios['update'] = ['name', 'email', 'password', 'confirm_password'];

        return $scenarios;
    }
}
