<?php
	
	namespace viktorals\news\controllers;

use Yii;
use common\models\tag;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TagController implements the CRUD actions for tag model.
 */
class TagController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }
    
    
    public function actionIndex()
    {
	    $model = new tag();
	    $dataProvider = new ActiveDataProvider([
		    'query' => tag::find()->orderBy(['id_tag'=>SORT_DESC]),'pagination' => [
			    'pageSize'=>'7'],
	    ]);
	    if ($model->load(Yii::$app->request->post()) && $model->save()) {
		    yii::$app->response->refresh();
	    }
        return $this->render('index', [
            'dataProvider' => $dataProvider,
	        'model'=>$model,
        ]);
    }
    

 
    public function actionUpdate($id)
    {
	    if (isset($_POST['hasEditable'])) {
		    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
		    $model = $this->findModel($id);
		    if (yii::$app->request->isAjax) {
			    $model->title = yii::$app->request->post('tags');
			    if ($model->save()){
				    return ['output'=>'', 'message'=>'','values'=>$model->title];
			    } else
				    return ['output'=>'', 'message'=>'При сохранении произошла ошибка, попробуйте ещё раз.'];
		    }
	    }
    }

  
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

  
    protected function findModel($id)
    {
        if (($model = tag::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
