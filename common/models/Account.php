<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\data\ActiveDataProvider;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

/**
 * User model
 *
 * @property integer $id [int(auto increment)]
 * @property string $user_id [UUID]
 * @property string $transferIban [varchar(254)]
 * @property string $account_name [varchar(254)]
 * @property string $created_at [datetime]
 *
 * @property AuthAssignment $role
 */
class Account extends ActiveRecord implements IdentityInterface
{

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%account}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['user_id', 'transferIban', 'account_name'], 'required', 'on' => 'default'],
            [['user_id', 'transferIban', 'account_name'], 'required', 'on' => 'create'],
            [['user_id', 'transferIban', 'account_name'], 'default', 'value' => NULL],
            ['transferIban', 'unique', 'on' => 'default'],
            ['transferIban', 'unique', 'on' => 'create'],
            /*['password_confirmation', 'compare', 'compareAttribute' => 'new_password', 'on' => 'create'],*/
            [['user_id', 'transferIban', 'account_name'], 'safe'],
            [['user_id', 'transferIban', 'account_name'], 'safe', 'on' => 'search'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'Id'),
            'user_id' => Yii::t('app', 'User Id'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::class,
                'createdAtAttribute' => 'created_at',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTransactions()
    {
        return $this->hasMany(Transaction::class, ['transferIban' => 'transferIban']);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id): User|IdentityInterface|null
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    public function search(array $params, bool $full = false): ActiveDataProvider
    {
        $this->scenario = 'search';

        $query = self::find();
        $query->leftJoin('{{%auth_assignment}}', '{{%auth_assignment}}.user_id = {{%user}}.id');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort'=> [
                'defaultOrder' => ['id'=>SORT_DESC],
            ]
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        if ($full) {
            $dataProvider->setPagination(false);
        } else {
            $dataProvider->pagination->pageSize = ($this->page_size !== NULL) ? $this->page_size : 20;
        }

        $id_arr = explode('-', $this->id);
        if (count($id_arr) == 2) {
            $query->andFilterWhere(['between', 'id', $id_arr[0], $id_arr[1]]);
        } else {
            $query->andFilterWhere(['id' => $this->id]);
        }

        $query->andFilterWhere([
            '{{%user}}.status' => $this->status,
            '{{%user}}.sex' => $this->sex,
            '{{%auth_assignment}}.item_name' => $this->item_name,
        ]);

        $query->andFilterWhere(['like', '{{%user}}.email', $this->email])
            ->andFilterWhere(['like', '{{%user}}.firstname', $this->firstname])
            ->andFilterWhere(['like', '{{%user}}.lastname', $this->lastname])
            ->andFilterWhere(['like', '{{%user}}.phone', $this->phone])
            ->andFilterWhere(['like', '{{%user}}.birth_date', $this->birth_date])
            ->andFilterWhere(['like', '{{%user}}.created_at', $this->created_at])
            ->andFilterWhere(['like', '{{%user}}.updated_at', $this->updated_at]);

        return $dataProvider;
    }



    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null): ?IdentityInterface
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey(): ?string
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey): ?bool
    {
        return $this->getAuthKey() === $authKey;
    }

}
