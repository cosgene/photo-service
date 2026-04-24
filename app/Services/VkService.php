<?php

class VkService {

    private $token;
    private $version = '5.199';

    public function __construct() {
        $this->token = $_ENV['VK_TOKEN'];
    }

    public function sendMessage($userId, $message, $keyboard = null) {
        if (!$this->token) {
            throw new Exception("VK_TOKEN not set");
        }

        $params = [
            'user_id' => $userId,
            'message' => $message,
            'random_id' => random_int(1, PHP_INT_MAX),
            'access_token' => $this->token,
            'v' => $this->version
        ];

        if ($keyboard) {
            $params['keyboard'] = json_encode($keyboard, JSON_UNESCAPED_UNICODE);
        }

        $response = file_get_contents("https://api.vk.com/method/messages.send?" . http_build_query($params));

        if ($response === false) {
            error_log("VK request failed");
        }
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
}
