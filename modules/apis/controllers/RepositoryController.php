<?php
namespace app\modules\apis\controllers;

use app\services\Repository;
use Yii;
use yii\web\Controller;
use yii\filters\Cors;


/**
 * @SWG\Swagger(
 *     basePath="/",
 *     produces={"application/json"},
 *     consumes={"application/x-www-form-urlencoded"},
 *     @SWG\Info(version="1.0", title="Repositories API"),
 * )
 */

class RepositoryController extends Controller
{
 
    public static function allowedDomains()
    {
        return [
            '*',                      
        ];
    }
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return array_merge(parent::behaviors(), [
            // For cross-domain AJAX request
            'corsFilter' => [
                'class' => Cors::className(),
                'cors' => [
                    // restrict access to domains:
                    'Origin' => static::allowedDomains(),
                    'Access-Control-Request-Method' => ['POST'],
                    'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600,                 // Cache (seconds)
                ],
            ],
        ]);
    }
    public function beforeAction($action)
    {

       Yii::$app->controller->enableCsrfValidation = false;
       \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        return parent::beforeAction($action);
    }
     /*
    *   Function to list the most popular repositories sorted by number of stars
    *   @params string $sort is the sort type by default will be stars
    *   @params as get
    *   @return SUCCESS - array of json (most popular repositories)
    *   @return ERROR   - error message 
    */

    /**
    * @SWG\Get(path="/apis/repository/list-repositories",
     *     tags={"Repository"},
     *     summary="Retrieves the collection of Repositories resources.",
         *	@SWG\Parameter(
     *        in = "body",
     *        name = "sort",
     *        description = "sort",
     *        required = false,
     *        type = "string",
     *      @SWG\Schema(ref = "#/definitions/Repository")
     *    ),
     *     @SWG\Response(
     *         response = 200,
     *         description = "Respositories collection response",
     *         @SWG\Schema(ref = "#/definitions/Repository")
     *     ),
     * )
     */

     public function actionListRepositories(){

        $data = file_get_contents("php://input");
        $data = json_decode($data);
        if(isset($data) && !empty($data->search_query)){
            $sort = $data->sort;
            $order = $data->order;
            $search_query = $data->search_query;
            $repoService = new Repository();
            $result =  $repoService->getRepoData($sort,$search_query,$order);
            return $result;
        }else{
            return ['status' => 404, 'msg' => 'Please enter a valid filtering parameters'];
        }
    
     }

}
