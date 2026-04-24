<?php

require_once __DIR__ . '/../Core/Logger.php';

class VkService {

    private $token;
    private $version = '5.199';

    public function __construct() {
        $this->token = $_ENV['VK_TOKEN'] ?? null;
    }

    public function sendMessage($userId, $message, $keyboard = null) {

        if (!$this->token) {
            Logger::log('error.log', 'VK_TOKEN EMPTY');
            return;
        }

        $params = [
            'user_id' => $userId,
            'message' => $message,
            'random_id' => random_int(1, PHP_INT_MAX),
            'access_token' => $this->token,
            'v' => $this->version
        ];

        if ($keyboard !== null && !empty($keyboard['buttons'])) {
            $params['keyboard'] = json_encode($keyboard, JSON_UNESCAPED_UNICODE);
        }

        $url = "https://api.vk.com/method/messages.send?" . http_build_query($params);

        $response = @file_get_contents($url);

        Logger::log('vk_api.log', $response ?: 'EMPTY RESPONSE');
    }

    public function getKeyboard() {
        return [
            "one_time" => false,
            "buttons" => [
                [
                    [
                        "action" => [
                            "type" => "text",
                            "label" => "Фотограф"
                        ],
                        "color" => "primary"
                    ]
                ],
                [
                    [
                        "action" => [
                            "type" => "text",
                            "label" => "Родитель"
                        ],
                        "color" => "secondary"
                    ]
                ]
            ]
        ];
    }

    public function hideKeyboard() {
        return [
            "buttons" => []
        ];
    }

}
