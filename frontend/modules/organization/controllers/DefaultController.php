<?php

namespace frontend\modules\organization\controllers;

use common\modules\organization\models\AddressAddForm;
use common\modules\organization\models\Address;
use common\modules\organization\models\KeyValueOrganization;
use common\modules\organization\models\Organization;
use frontend\modules\organization\widget\BookmarkWidget;
use Yii;
use common\modules\organization\models\AddOrgForm;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

class DefaultController extends Controller
{
    public function actionIndex()
    {
//        $model = Organization::findOne(5);
//        $key = new KeyValueOrganization();
//        $key->saveValue($model);
//
//        $model = Organization::findOne(6);
//        $key = new KeyValueOrganization();
//        $key->saveValue($model);
//
//        $model = Organization::findOne(7);
//        $key = new KeyValueOrganization();
//        $key->saveValue($model);
//
//        $model = Organization::findOne(9);
//        $key = new KeyValueOrganization();
//        $key->saveValue($model);
//
//        $model = Organization::findOne(10);
//        $key = new KeyValueOrganization();
//        $key->saveValue($model);


        return $this->render('index');
    }

    /**
     * Добавляем новую организацию
     * @return View
     */
    public function actionNew()
    {
        if (Yii::$app->user->getIsGuest())
        {
            Yii::$app->session->setFlash('org_add_guest', '<p>Войдите, чтобы добавить организацию.</p>');
        } else {
            $model = new AddOrgForm();
            $address = [new AddressAddForm()];

            $validate = true;

            if ($model->load(\Yii::$app->request->post())) {

                $_post_address = Yii::$app->request->post('AddressAddForm');

                foreach ($_post_address as $index => $_post_arr) {

                    $address[$index] = new AddressAddForm();
                    $address[$index]->setAttributes($_post_arr);
                    $validate = $validate && $address[$index]->validate();
                }
                $model->address = $address;
                if ($model->validate() && $validate) {
                    if ($model->save()) {
                        Yii::$app->session->setFlash('org_add_success', '<p>Спасибо за добавление организации.<br />Организация будет добавлена после премодерации.</p>');
                    }
                }
            }

            return $this->render('new', ['model' => $model, 'address' => $address]);
        }
    }

    /**
     * Поиск
     * @return View
     */
    public function actionSearchResult()
    {
        $search_value = Yii::$app->request->get('search_value');
       // $region = Yii::$app->request->get('region');

        $query = KeyValueOrganization::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query
        ]);
        $dataProvider->query->andWhere(['like', 'value', $search_value]);
       // $dataProvider->query->andWhere(['like', 'value', $region]);
        $dataProvider->pagination->pageSize = 20;

        return $this->render('search-result', [
            'dataProvider' => $dataProvider,
            'search_value' => $search_value
        ]);
    }

    /**
     * Отображаем организацию
     * @return View
     * @throws \yii\web\NotFoundHttpException
     */
    public function actionShow()
    {
        $id = Yii::$app->request->get('id');
        $model = Organization::findOne((int)$id);
        $model->setCookie();

        if (empty($model))
            throw new NotFoundHttpException('Организация не найдена.');


        return $this->render('show', [
            'model' => $model
        ]);
    }

    /**
     * Добавить закладку
     * Ajax
     * @return Html string Ajax result
     */
    public function actionAddBookmark()
    {
        if (Yii::$app->request->isAjax) {
            $bookmarks = Yii::$app->session->get('bookmarks');
            $id = Yii::$app->request->get('id');
            if ($bookmarks != "") {
                $bookmarks = unserialize($bookmarks);
                if (!in_array($id, $bookmarks)) {
                    $bookmarks[count($bookmarks)] = $id;
                }
            } else {
                $bookmarks[] = $id;
            }
            Yii::$app->session->set('bookmarks', '');
            Yii::$app->session->set('bookmarks', serialize($bookmarks));
            $result = BookmarkWidget::widget();
            echo $result;
            Yii::$app->end();
        }
    }

    /**
     * Убрать закладку
     * Ajax
     * @return Html string Ajax result
     */
    public function actionRemoveFromBookmarks()
    {
        if (Yii::$app->request->isAjax) {
            $bookmarks = Yii::$app->session->get('bookmarks');
            $id = Yii::$app->request->get('id');
            $temp = [];
            if ($bookmarks != "") {
                $bookmarks = unserialize($bookmarks);
                foreach ($bookmarks as $_org_id) {
                    if ($_org_id != $id) {
                        $temp[] = $_org_id;
                    }
                }
                Yii::$app->session->set('bookmarks', '');
                Yii::$app->session->set('bookmarks', serialize($temp));
            }
            $result = BookmarkWidget::widget();
            echo $result;
            Yii::$app->end();
        }
    }

//    public function actionParseXml()
//    {
//        $get = file_get_contents(Yii::$app->basePath."/../".'/files/1.xml');
//        $arr = simplexml_load_string($get);
//        $point = $arr;
//        $count = 0;
//        foreach ($point as $index => $org) {
//            echo "Name ".$org->Name."<br />\n";
//            echo "Address ".$org->Address->Settlement." ".$org->Address->Street." ".$org->Address->Building." ".$org->Address->Room."<br />\n";
//            echo "Longitude ".$org->Address->Longitude."<br />\n";
//            echo "Latitude ".$org->Address->Latitude."<br />\n";
//            $phone = "";
//            if (count($org->Phones) > 0) {
//                foreach ($org->Phones as $_p) {
//                    $phone .= " ".$_p->Phone;
//                }
//            }
//            echo "Phone ".$phone."<br />\n"."<br />\n";
//            $count++;
//        }
//        echo $count;
//        return $this->render('parse');
//    }

//    public function actionParse()
//    {
//        $url = 'D:\OpenServer\domains\yellow_pages\files\1.xml';
//
//        $data = simplexml_load_file($url);
//
//        $model = new Organization();
//        $address = new Address();
//
//        $id = 11;
//        $addressID = 6;
//
//        foreach ($data->Point as $point)
//        {
//            $model->id = $address->org_id = $id++;
//            $address->id = $addressID++;
//            $model->name = $point->Name;
//
//            $address->address = '';
//            if (!($point->Address->Settlement == ''))
//                $address->address .= $point->Address->Settlement;
//            if (!($point->Address->Street == ''))
//                $address->address .= ", ".$point->Address->Street;
//            if (!($point->Address->Building == ''))
//                $address->address .= ", ".$point->Address->Building;
//            if (!($point->Address->Room == ''))
//                $address->address .= ", ".$point->Address->Room;
//            if (!($point->Address->PostIndex == ''))
//                $address->address .= ", ".$point->Address->PostIndex;
//
//            $address->longitude = $point->Address->Longitude;
//            $address->latitude = $point->Address->Latitude;
//
//            $address->phone = '';
//            foreach($point->Phones->Phone as $phone)
//            {
//                $address->phone.= $phone." ";
//
//            }
//
//            $model->insert(false);
//            $address->insert(false);
//        }
//        return $this->render('parse');
//    }
}
