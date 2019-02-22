<?php

namespace linnoxlewis\iap;

use linnoxlewis\iap\interfaces\IapInterface;
use linslin\yii2\curl;
use yii\base\Component;

/**
 * Class IapComponent.
 * Компонет верификации рецепта.
 *
 */
class IapComponent extends Component implements IapInterface
{
    /**
     * Режим покупки.
     *
     * @var bool
     */
    public $sandbox;
    /**
     * Режим пароль.
     *
     * @var string
     */
    public $password;

    /**
     * Cсылка на ендпоинт верефикации в тестовом режиме.
     *
     * @var string
     */
    public $sandboxUrl;
    /**
     * Cсылка на ендпоинт верефикации в рабочем режиме.
     *
     * @var string
     */
    public $buyUrl;

    /**
     * Формирует данные для отправки на эпл сервер.
     *
     * @param string $receipt рецепт МП.
     *
     * @return string
     */
    protected function getDataForRequest($receipt) : string
    {
        if ($this->password == '') {
            return json_encode(['receipt-data' => $receipt]);
        }

        return json_encode(['receipt-data' => $receipt, 'password' => $this->password]);
    }

    /**
     * Метод отправки рецепта на эпл сервер.
     *
     * @param string $requestData данные для отправки.
     * @param string $verifyUrl адрес сервера.
     *
     * @throws IapRequestException
     * @return object
     */
    protected function getResponseFromApi(string $requestData, string $verifyUrl)
    {
        $curl = new curl\Curl();
        $response = $curl->setRawPostData($requestData)
            ->post($verifyUrl);

        if ($response == null) {
            throw new IapRequestException("request failed",500);
        }

        return json_decode($response);
    }

    /**
     * Формирование адреса сервера верефикации.
     *
     * @return string
     */
    protected function getVerifyUrl() : string
    {
        return YII_ENV_PROD ? $this->buyUrl : $this->sandboxUrl;
    }

    /**
     * Метод верификации рецепта покупки.
     *
     * @param string $receipt закодированный рецепт поукпки.
     *
     * @throws \Exception
     * @return array
     */
    public function verify(string $receipt) : array
    {
        $requestData = $this->getDataForRequest($receipt);
        $verifyUrl = $this->getVerifyUrl();
        $result = $this->getResponseFromApi($requestData, $verifyUrl);
        $resultStatus = ($result->status == 200) ? 'Succsess' : 'Failed';

        return [
            'meta' => $resultStatus,
            'data' => $result
        ];
    }
}
