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
    public static function tableName(): string
    {
        return '{{%user}}';
    }

    public function rules(): array
    {
        return [
            [['name', 'email', 'password'], 'required'],
            ['email', 'email'],
            ['email', 'unique'],
            [['created_at', 'updated_at'], 'integer'],
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
        return parent::beforeSave($insert);
    }
}
