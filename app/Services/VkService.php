<?php

class VkService {

    private $token = 'vk1.a.zA7mBqZ858Ms-HhPcEZ044P9qrhAbG_ifvDX5riGmOLnigi1vEb5cekDgaRAyv50hgBnMwf4Jg6Y6SQODl22O1k_GOkzkPHAz-52TRq9WWSP5SbgX_HHKkelj4g8dJ20mjAtkMK-fZppMbopNYNadJ-HHuqMMroxWZ0yBncmNddJgjPlk7wXcpf3O2lihA8IWRDVZNdpnQHymvgFI7M7yA';
    private $version = '5.131';

    public function sendMessage($userId, $message, $keyboard = null) {
        $params = [
            'user_id' => $userId,
            'message' => $message,
            'random_id' => rand(),
            'access_token' => $this->token,
            'v' => $this->version
        ];

        if ($keyboard) {
            $params['keyboard'] = json_encode($keyboard);
        }

        file_get_contents("https://api.vk.com/method/messages.send?" . http_build_query($params));
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
