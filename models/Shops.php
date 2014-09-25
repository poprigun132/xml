<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "shops".
 *
 * @property integer $id_shop
 * @property integer $id_user
 * @property integer $id_currency
 * @property string $name
 * @property string $url
 * @property string $mail
 * @property string $mail_subject
 * @property double $percent
 * @property integer $percent_designer
 * @property double $nadbavka
 * @property integer $autoupdate
 * @property integer $status
 * @property integer $sort
 * @property string $sortn
 * @property integer $defaultmodel
 * @property integer $application
 * @property string $logo
 * @property integer $inrow
 * @property string $google
 * @property string $yandex
 * @property string $vkontakte
 * @property integer $edited
 * @property integer $fill_blanks_min_goods
 * @property integer $fill_blanks
 * @property integer $fill_blanks_from_parent
 * @property double $old_price_percent
 * @property integer $showcase_view
 * @property integer $pop_count
 * @property integer $new_count
 * @property integer $recom_count
 * @property integer $random_count
 * @property integer $id_dragon
 * @property integer $default_product_desc
 * @property integer $default_category_desc
 * @property integer $hide_product_desc
 * @property integer $extramodel
 * @property integer $custom_product_title
 * @property integer $indexation
 * @property integer $custom_category_title
 * @property integer $reviews_status
 * @property integer $set_country
 * @property string $google_secret_key
 * @property string $google_client_id
 * @property integer $google_profile_id
 * @property string $google_service_email
 * @property string $date
 * @property integer $mirror_sh_goods_desc
 * @property integer $mirror_sh_cat_desc
 * @property string $robots.txt
 * @property string $robots1
 * @property string $robots2
 * @property string $privileges
 * @property string $favicoName
 * @property string $ab_test_code
 * @property string $counters
 * @property string $counters_start
 * @property integer $delivery_city
 * @property integer $microrazmetka
 * @property integer $default_chat
 * @property string $real_author
 * @property integer $rating
 * @property string $end2Head
 * @property string $end2Body
 * @property string $end3Head
 * @property string $end3Body
 */
class Shops extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shops';
    }

	/**
	 * @return \yii\db\Connection the database connection used by this AR class.
	 */
	public static function getDb()
	{
		return Yii::$app->get('db_AP');
	}

	/**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_user', 'id_currency', 'name', 'url', 'mail', 'mail_subject', 'percent', 'percent_designer', 'nadbavka', 'autoupdate', 'status', 'sortn', 'defaultmodel', 'application', 'logo', 'google', 'yandex', 'vkontakte', 'edited', 'fill_blanks_min_goods', 'fill_blanks', 'old_price_percent', 'pop_count', 'new_count', 'recom_count', 'robots.txt', 'robots1', 'robots2', 'privileges', 'ab_test_code', 'counters', 'end2Head', 'end2Body', 'end3Head', 'end3Body'], 'required'],
            [['id_user', 'id_currency', 'percent_designer', 'autoupdate', 'status', 'sort', 'defaultmodel', 'application', 'inrow', 'edited', 'fill_blanks_min_goods', 'fill_blanks', 'fill_blanks_from_parent', 'showcase_view', 'pop_count', 'new_count', 'recom_count', 'random_count', 'id_dragon', 'default_product_desc', 'default_category_desc', 'hide_product_desc', 'extramodel', 'custom_product_title', 'indexation', 'custom_category_title', 'reviews_status', 'set_country', 'google_profile_id', 'mirror_sh_goods_desc', 'mirror_sh_cat_desc', 'delivery_city', 'microrazmetka', 'default_chat', 'rating'], 'integer'],
            [['mail', 'sortn', 'google', 'yandex', 'vkontakte', 'robots.txt', 'robots1', 'robots2', 'privileges', 'ab_test_code', 'counters', 'counters_start', 'real_author', 'end2Head', 'end2Body', 'end3Head', 'end3Body'], 'string'],
            [['percent', 'nadbavka', 'old_price_percent'], 'number'],
            [['date'], 'safe'],
            [['name', 'url', 'mail_subject', 'logo'], 'string', 'max' => 255],
            [['google_secret_key', 'google_client_id', 'google_service_email'], 'string', 'max' => 100],
            [['favicoName'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id_shop' => 'Id Shop',
            'id_user' => 'Id User',
            'id_currency' => 'Id Currency',
            'name' => 'Name',
            'url' => 'Url',
            'mail' => 'Mail',
            'mail_subject' => 'Mail Subject',
            'percent' => 'Percent',
            'percent_designer' => 'Percent Designer',
            'nadbavka' => 'Nadbavka',
            'autoupdate' => 'Autoupdate',
            'status' => 'Status',
            'sort' => 'Sort',
            'sortn' => 'Sortn',
            'defaultmodel' => 'Defaultmodel',
            'application' => 'Application',
            'logo' => 'Logo',
            'inrow' => 'Inrow',
            'google' => 'Google',
            'yandex' => 'Yandex',
            'vkontakte' => 'Vkontakte',
            'edited' => 'Edited',
            'fill_blanks_min_goods' => 'Fill Blanks Min Goods',
            'fill_blanks' => 'Fill Blanks',
            'fill_blanks_from_parent' => 'Fill Blanks From Parent',
            'old_price_percent' => 'Old Price Percent',
            'showcase_view' => 'Showcase View',
            'pop_count' => 'Pop Count',
            'new_count' => 'New Count',
            'recom_count' => 'Recom Count',
            'random_count' => 'Random Count',
            'id_dragon' => 'Id Dragon',
            'default_product_desc' => 'Default Product Desc',
            'default_category_desc' => 'Default Category Desc',
            'hide_product_desc' => 'Hide Product Desc',
            'extramodel' => 'Extramodel',
            'custom_product_title' => 'Custom Product Title',
            'indexation' => 'Indexation',
            'custom_category_title' => 'Custom Category Title',
            'reviews_status' => 'Reviews Status',
            'set_country' => 'Set Country',
            'google_secret_key' => 'Google Secret Key',
            'google_client_id' => 'Google Client ID',
            'google_profile_id' => 'Google Profile ID',
            'google_service_email' => 'Google Service Email',
            'date' => 'Date',
            'mirror_sh_goods_desc' => 'Mirror Sh Goods Desc',
            'mirror_sh_cat_desc' => 'Mirror Sh Cat Desc',
            'robots.txt' => 'Robots Txt',
            'robots1' => 'Robots1',
            'robots2' => 'Robots2',
            'privileges' => 'Privileges',
            'favicoName' => 'Favico Name',
            'ab_test_code' => 'Ab Test Code',
            'counters' => 'Counters',
            'counters_start' => 'Counters Start',
            'delivery_city' => 'Delivery City',
            'microrazmetka' => 'Microrazmetka',
            'default_chat' => 'Default Chat',
            'real_author' => 'Real Author',
            'rating' => 'Rating',
            'end2Head' => 'End2 Head',
            'end2Body' => 'End2 Body',
            'end3Head' => 'End3 Head',
            'end3Body' => 'End3 Body',
        ];
    }
}
