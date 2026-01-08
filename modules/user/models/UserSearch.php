<?php

namespace app\modules\user\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

class UserSearch extends Model
{
    public $name;
    public $email;

    public function rules(): array
    {
        return [
            [['name', 'email'], 'safe'],
        ];
    }

    public function search(array $params): ActiveDataProvider
    {
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 5,
            ],
            'sort' => [
                'defaultOrder' => ['id' => SORT_DESC],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'name', $this->name])
              ->andFilterWhere(['like', 'email', $this->email]);

        return $dataProvider;
    }
}
