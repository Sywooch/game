<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%game}}".
 *
 * @property integer $id
 * @property integer $category_id
 * @property string $title
 * @property string $file
 * @property string $img
 *
 * @property Category $category
 */
class Game extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%game}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'title', 'file', 'img'], 'required'],
            [['category_id'], 'integer'],
            [['title', 'file', 'img'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Категория',
            'title' => 'Заголовок',
            'file' => 'Файл',
            'img' => 'Изображение',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
}
