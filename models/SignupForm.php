<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model{
    public string $name = '';
    public string $email = '';
    public string $password = '';

    /**
     * Register rules
     * @return array<array|array{min: int|array{targetClass: string}>}
     */
    public function rules(): array
    {
        return [
            [['name', 'email', 'password'], 'required'],
            ['name', 'string', 'min' => 4],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => User::class],
            ['password', 'string', 'min' => 5],
        ];
    }

    /**
     * Summary of signup
     * @return User|null
     */
    public function signup(): ?User
    {
        if (!$this->validate()) {
            return null;
        }

        $user = new User();
        $user->name = $this->name;
        $user->email = $this->email;
        $user->setPassword($this->password);

        return $user->save() ? $user : null;
    }

}
