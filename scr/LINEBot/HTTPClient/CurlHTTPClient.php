<?php

/**
 * Copyright 2016 LINE Corporation
 *
 * LINE Corporation licenses this file to you under the Apache License,
 * version 2.0 (the "License"); you may not use this file except in compliance
 * with the License. You may obtain a copy of the License at:
 *
 *   https://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License.
 */

namespace D10419103\scr\LINEBot\HTTPClient;

use D10419103\scr\LINEBot\Constant\Meta;
use D10419103\scr\LINEBot\Exception\CurlExecutionException;
use D10419103\scr\LINEBot\HTTPClient;
use D10419103\scr\LINEBot\Response;
use D10419103\scr\LINEBot\HTTPClient\Curl;

/**
 * Class CurlHTTPClient.
 *
 * A HTTPClient that uses cURL.
 *
 * @package LINE\LINEBot\HTTPClient
 */
class CurlHTTPClient implements HTTPClient
{
    /** @var array */
    private $authHeaders;
    /** @var array */
    private $userAgentHeader = ['User-Agent: LINE-BotSDK-PHP/' . Meta::VERSION];

    /**
     * CurlHTTPClient constructor.
     *
     * @param string $channelToken Access token of your channel.
     */
    public function __construct($channelToken)
    {
        $this->authHeaders = [
            "Authorization: Bearer $channelToken",
        ];
    }

    /**
     * Sends GET request to LINE Messaging API.
     *
     * @param string $url Request URL.
     * @return Response Response of API request.
     */
    public function get($url)
    {
        return $this->sendRequest('GET', $url, [], []);
    }

    /**
     * Sends POST request to LINE Messaging API.
     *
     * @param string $url Request URL.
     * @param array $data Request body.
     * @return Response Response of API request.
     */
    public function post($url, array $data)
    {
        return $this->sendRequest('POST', $url, ['Content-Type: application/json; charset=utf-8'], $data);
    }

    /**
     * @param string $method
     * @param string $url
     * @param array $additionalHeader
     * @param array $reqBody
     * @return Response
     * @throws CurlExecutionException
     */
    private function sendRequest($method, $url, array $additionalHeader, array $reqBody)
    {
        $curl = new Curl($url);

        $headers = array_merge($this->authHeaders, $this->userAgentHeader, $additionalHeader);

        $options = [
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_BINARYTRANSFER => true,
        ];

        if ($method === 'POST' && !empty($reqBody)) {
            $options[CURLOPT_POSTFIELDS] = json_encode($reqBody);
        }

        $curl->setoptArray($options);

        $body = $curl->exec();

        $info = $curl->getinfo();
        $httpStatus = $info['http_code'];

        if ($curl->errno()) {
            throw new CurlExecutionException($curl->error());
        }

        return new Response($httpStatus, $body);
    }
}
