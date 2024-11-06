<?php

namespace common\models;

use admin\components\parsers\ParserInterface;
use admin\components\uploadForm\models\UploadForm;
use admin\components\uploadForm\models\UploadInterface;
use common\models\AppActiveRecord;
use common\modules\user\models\User;
use OpenSpout\Common\Entity\Cell;
use Yii;
use yii\db\ActiveQuery;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%code}}".
 *
 * @property int               $id
 * @property string|null       $code
 * @property string|null       $promocode
 * @property int|null          $code_category_id
 * @property int|null          $user_id
 * @property int|null          $taken_at
 * @property int|null          $user_ip
 * @property int|null          $public_status
 *
 * @property-read CodeCategory $codeCategory
 */
class Code extends AppActiveRecord implements UploadInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%code}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['code_category_id', 'user_id', 'taken_at', 'user_ip', 'public_status'], 'integer'],
            [['code'], 'string', 'max' => 6],
            [['promocode'], 'string', 'max' => 255],
            [['code_category_id'], 'exist', 'skipOnError' => true, 'targetClass' => CodeCategory::class, 'targetAttribute' => ['code_category_id' => 'id']]
        ];
    }

    /**
     * {@inheritdoc}
     */
    final public function attributeLabels(): array
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'promocode' => Yii::t('app', 'Promocode'),
            'code_category_id' => Yii::t('app', 'Code Category ID'),
            'user_id' => Yii::t('app', 'User ID'),
            'taken_at' => Yii::t('app', 'Taken At'),
            'user_ip' => Yii::t('app', 'User Ip'),
            'public_status' => Yii::t('app', 'Public Status'),
        ];
    }

    final public function getCodeCategory(): ActiveQuery
    {
        return $this->hasOne(CodeCategory::class, ['id' => 'code_category_id']);
    }

    final public function getUser(): ActiveQuery
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public static function externalAttributes(): array
    {
        return ['user.username'];
    }

    public static function insertFromFile(UploadForm $model, ParserInterface $parser): void
    {
        $rows = [];

        $parser->fileRowIterate(
            $model->file->tempName,
            /**
             * @param Cell[] $cells
             */
            static function (array $cells, int $key) use ($model, &$rows) {
                if ($key === 1) {
                    return;
                }

                $rows[] = [
                    'code' => $cells[0]->getValue(),
                    'promocode' => $cells[1]->getValue(),
                    'code_category_id' => $model->code_category_id,
                ];
            }
        );

        if (!empty($rows)) {
            Yii::$app->db->createCommand()
                ->batchInsert(
                    '{{%code}}',
                    ['code', 'promocode', 'code_category_id'],
                    $rows
                )
                ->execute();
        }
    }
}
