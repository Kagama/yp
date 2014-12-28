<?php

namespace backend\modules\organization\controllers;

use common\modules\organization\models\ElasticKeyValue;
use Yii;
use common\modules\organization\models\Organization;
use common\modules\organization\search\OrganizationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\modules\admin\models\AdminUsers;
use yii\web\UploadedFile;

/**
 * DefaultController implements the CRUD actions for Organization model.
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],

            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'create', 'update', 'delete'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['index', 'view', 'create', 'update', 'delete'],
                        'matchCallback' => function ($rule, $action) {
                                $model = AdminUsers::findIdentity(Yii::$app->user->getId());
                                if (!empty($model)) {
                                    return $model->getRoleId() == 1; // Администратор
                                }
                                return false;
                            }
                    ]
                ]
            ]
        ];
    }

    /**
     * Lists all Organization models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrganizationSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Displays a single Organization model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $contacts = '';
        foreach($model->address as $id => $contact)
        {
            $num = $id + 1;
            $contacts .= '<fieldset> <h1>'.$num.'.</h1>';
            $contacts .= '<p> <strong> Название отделения:</strong> '.$contact->point_name.'</p>';
            $contacts .= '<p> <strong>Адрес:</strong> '.$contact->address.'</p>';
            $contacts .= '<p> <strong>Номер телефона:</strong> '.$contact->phone.'</p>';
            $contacts .= '<p> <strong>Факс:</strong> '.$contact->fax.'</p>';
            $contacts .= '</fieldset>';
        }
        return $this->render('view', [
            'model' => $model,
            'contacts' => $contacts,
        ]);
    }

    /**
     * Creates a new Organization model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Organization;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Organization model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Organization model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Organization model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Organization the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Organization::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Approve all organizations
     * @return mixed
     */
    public function actionApproveAll()
    {
        $orgs = Organization::find(['approve' != 1])->all();
        foreach ($orgs as $org) {
            $elastic = new ElasticKeyValue();
            $org->approve = 1;
            $org->updateAttributes(['approve']);
            $elastic->saveValue($org);
        }

        return $this->redirect(['index']);
    }
}
