<?php

namespace common\modules\organization\models;


//use common\modules\locality\models\Region;
use Yii;
use yii\base\Model;
use common\models\Tags;
use common\helpers\CDirectory;
use common\helpers\CString;
use yii\web\UploadedFile;

/**
 * Created by PhpStorm.
 * User: developer
 * Date: 05.05.14
 * Time: 17:25
 */
class AddOrgForm extends Model
{
    public $category;
    public $tags;
    public $name;
    public $description;
    public $address;
    public $latitude;
    public $longitude;
    public $org_type;
    public $top_manager;
    public $contacts_email;
    public $contacts_site;
    public $img;


    private $_identity;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['name', 'description', 'category'], 'required'],
            [['tags'], 'string', 'max' => 1024],
            [['contacts_email'], 'string', 'max' => 128],
            [['contacts_email'], 'email'],
            [['contacts_site'], 'string', 'max' => 512],
            [['contacts_site'], 'url'],
            [['latitude', 'longitude', 'org_type'], 'double'],
            [['description', 'top_manager'], 'string', 'max' => Yii::$app->params['max_length_text_field']],
            [['img'], 'image', 'extensions' => 'jpg, png', 'mimeTypes' => 'image/jpeg, image/png',],
        ];
    }

    /**
     * Declares attribute labels.
     */
    public function attributeLabels()
    {
        return [
            'name' => 'Название организации',
            'description' => 'Описание деятельности (например: Продажа автомобилей BMW, Mersedes, сервисное обслуживание, ремонт).',
//            'region' => 'Регион',
//            'address' => 'Адрес компании',
            'category' => 'Рубрикатор',
            'top_manager' => 'ФИО руководителя (не публикуется)',
            'org_type' => 'Организационно-правовая форма',
            'tags' => 'Тематические теги (например: Ролы, Салаты, Живая музыка)',
            'contacts_email' => 'E-mail (например: info@info.ru)',
            'contacts_site' => 'Адрес сайта (например: http://www.kagama.ru)',
            'img' => 'Фотография',
        ];
    }

    public function save()
    {
//        return false;
        $org = new Organization();
        $org->approve = 0;
        $org->registration_date = time(); // TIME NOW

        $org->name = $this->name;
        $org->description = $this->description;
        $org->category = $this->category;
        $org->org_type = $this->org_type;
        $org->top_manager = $this->top_manager;

        // Теги
        $org->tags = $this->tags;
        $tag = new Tags();
        $tag->add($this->tags);

        $image = UploadedFile::getInstance($this, 'img');

        if ($image) {
            $date = getdate();
            $path = 'images/' . $date['year'] . '/' . $date['mon'] . '/' . $date['mday'] . '/' . $this->name;
            CDirectory::createDir($path);
            $dir = Yii::$app->basePath . "/../" . $path;
            $imageName = md5(CString::translitTo($image) . microtime()) . "." . $image->getExtension();
            $image->saveAs($dir . "/" . $imageName);
            $org->img_src = $path;
            $org->img = $imageName;
        }

        if ($org->save()) {
            $primaryKey = $org->getPrimaryKey();

            //Адреса
            if (!empty($this->address)) {
                foreach ($this->address as $index => $_address) {
                    $_add = new Address();
                    $_add->address = $_address->address;
                    $_add->point_name = $_address->point_name;
                    $_add->phone = $_address->phone;
                    $_add->fax = $_address->fax;
                    $_add->org_id = $primaryKey;
                    $_add->save();
                }
            }


            // Контакты
//            if (!empty($this->contacts_phone)) {
//                $contact = new ContactInfo();
//                $contact->group_id = 1; // Рабочий номер телефона
//                $contact->value = $this->contacts_phone;
//                $contact->organization_id = $primaryKey;
//                $contact->save();
//            }

//            if (!empty($this->contacts_fax)) {
//                $contact = new ContactInfo();
//                $contact->group_id = 4; // Факс
//                $contact->value = $this->contacts_fax;
//                $contact->organization_id = $primaryKey;
//                $contact->save();
//            }

            if (!empty($this->contacts_email)) {
                $contact = new ContactInfo;
                $contact->group_id = 3; // Email
                $contact->value = $this->contacts_email;
                $contact->organization_id = $primaryKey;
                $contact->save();
            }

            if (!empty($this->contacts_site)) {
                $contact = new ContactInfo;
                $contact->group_id = 5; // Сайт
                $contact->value = $this->contacts_site;
                $contact->organization_id = $primaryKey;
                $contact->save();
            }

            if (isset($_POST['workdays_from'])) {
                $workDaysFrom = $_POST['workdays_from'];
                $workDaysTo = $_POST['workdays_to'];

                $workHoursFrom = $_POST['workhours_from'];
                $workHoursTo = $_POST['workhours_to'];

                foreach ($workDaysFrom as $index => $days) {
                    if (!empty($days)) {
                        $work = new WorkDaysAndTime();
                        $work->organization = $primaryKey;
                        $work->work_day_from = $days;
                        $work->work_day_to = $workDaysTo[$index];
                        $work->work_hours_from = $workHoursFrom[$index];
                        $work->work_hours_to = $workHoursTo[$index];
                        $work->save();
                    }

                }
            }

            $key = new KeyValueOrganization();
            $key->saveValue($org);

            return true;
        } else {
            print_r($org->getErrors());
        }


    }


}