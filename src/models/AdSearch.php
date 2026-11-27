<?php

declare(strict_types=1);

namespace larikmc\ad\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * AdSearch represents the model behind the search form of `larikmc\ad\models\Ad`.
 */
class AdSearch extends Ad
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['id', 'position_id', 'status', 'mobile', 'ad'], 'integer'],
            [['code', 'comment', 'config', 'theme'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios(): array
    {
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function search(array $params): ActiveDataProvider
    {
        $query = Ad::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 100,
            ],
            'sort' => ['defaultOrder' => ['id' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'position_id' => $this->position_id,
            'status' => $this->status,
            'mobile' => $this->mobile,
            'ad' => $this->ad,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'comment', $this->comment])
            ->andFilterWhere(['like', 'config', $this->config])
            ->andFilterWhere(['like', 'theme', $this->theme]);

        return $dataProvider;
    }
}
