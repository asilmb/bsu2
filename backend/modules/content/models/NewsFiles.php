<?php

namespace backend\modules\content\models;

use Yii;

/**
 * This is the model class for table "{{%news_files}}".
 *
 * @property integer $id
 * @property string $entity
 * @property integer $entityId
 * @property string $entityAttribute
 * @property integer $parentId
 * @property string $childName
 * @property string $uploadDate
 * @property integer $fileOrder
 * @property string $relativePath
 * @property string $completePath
 * @property string $webPath
 * @property string $originalFileName
 * @property string $fileName
 * @property string $mimeType
 * @property string $extension
 * @property integer $fileSize
 * @property string $exif
 * @property integer $userId
 * @property integer $updated
 */
class NewsFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_files}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity', 'entityId', 'entityAttribute', 'parentId', 'uploadDate', 'fileOrder', 'relativePath', 'completePath', 'webPath', 'originalFileName', 'fileName', 'mimeType', 'extension', 'fileSize'], 'required'],
            [['entityId', 'parentId', 'fileOrder', 'fileSize', 'userId', 'updated'], 'integer'],
            [['uploadDate'], 'safe'],
            [['exif'], 'string'],
            [['entity', 'entityAttribute', 'childName', 'originalFileName', 'fileName', 'mimeType', 'extension'], 'string', 'max' => 255],
            [['relativePath', 'completePath', 'webPath'], 'string', 'max' => 512],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity' => 'Entity',
            'entityId' => 'Entity ID',
            'entityAttribute' => 'Entity Attribute',
            'parentId' => 'Parent ID',
            'childName' => 'Child Name',
            'uploadDate' => 'Upload Date',
            'fileOrder' => 'File Order',
            'relativePath' => 'Relative Path',
            'completePath' => 'Complete Path',
            'webPath' => 'Web Path',
            'originalFileName' => 'Original File Name',
            'fileName' => 'File Name',
            'mimeType' => 'Mime Type',
            'extension' => 'Extension',
            'fileSize' => 'File Size',
            'exif' => 'Exif',
            'userId' => 'User ID',
            'updated' => 'Updated',
        ];
    }
}
