<?php

namespace sillsoft\novaposhta\controllers;

use sillsoft\novaposhta\components\NovaPoshtaApi;
use Yii;
use yii\base\InvalidConfigException;
use yii\di\NotInstantiableException;
use yii\web\Controller;
use yii\web\Response;

/**
 * Class DefaultController
 * @package sillsoft\novaposhta\controllers
 */
class DefaultController extends Controller
{
    /**
     * @return Response
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function actionCities(): Response
    {
        $lang = Yii::$app->language;
        $np = Yii::$container->get(NovaPoshtaApi::class);
        $result = $np->getCities(1, Yii::$app->getRequest()->post('search')['term']);
        if (array_key_exists('data', $result)) {

            foreach ($result['data'] as $city) {

                $data[] = [
                    'id' => $lang == 'uk' ? $city['Description'] : $city['DescriptionRu'],
                    'text' => $lang == 'uk' ? $city['Description'] : $city['DescriptionRu'],
                ];
            }
        }
        return $this->asJson([
            'results' => $data ?? []
        ]);
    }

    /**
     * @return Response
     * @throws InvalidConfigException
     * @throws NotInstantiableException
     */
    public function actionWarehouses(): Response
    {
        $lang = Yii::$app->language;
        $request = Yii::$app->getRequest();
        $np = Yii::$container->get(NovaPoshtaApi::class);
        $city = $request->post('city_id');
        $result = $np->getWarehousesByRef($city, '');
        if (array_key_exists('data', $result)) {

            foreach ($result['data'] as $type) {

                $data[] = [
                    'id' => $lang == 'uk' ? $type['Description'] : $type['DescriptionRu'],
                    'text' => $lang == 'uk' ? $type['Description'] : $type['DescriptionRu'],
                ];
            }
        }
        return $this->asJson([
            'results' => $data ?? []
        ]);
    }
}