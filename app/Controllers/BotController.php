<?php

require_once __DIR__ . '/../Services/VkService.php';
require_once __DIR__ . '/../Core/Database.php';


class BotController {

    public function handle() {
        $input = file_get_contents('php://input');
        $data = json_decode($input, true);

        if (!$data) {
            echo "no data";
            return;
        }

        if (!isset($data['type'])) {
            echo "no type";
            return;
        }

        if ($data['type'] === 'confirmation') {
            echo '71e55f54';
            exit;
        }

        if ($data['type'] === 'message_new') {
            $this->handleMessage($data['object']['message']);
        }

        echo 'ok';
    }


    private function handleMessage($message) {
        $userId = $message['from_id'];
        $text = trim($message['text']);

        $vk = new VkService();

        switch ($text) {

            case 'Фотограф':
                $vk->sendMessage(
                    $userId,
                    "📸 Привет! Вы вошли как фотограф.\n\nЗагружайте фотографии лагеря — система обработает их и сопоставит с детьми."
                );
                break;

            case 'Родитель':
                $vk->sendMessage(
                    $userId,
                    "👨‍👩‍👧 Привет! Вы вошли как родитель.\n\nОтправьте фото вашего ребенка, и мы найдём все его фотографии в лагере."
                );
                break;

            default:
                $vk->sendMessage(
                    $userId,
                    "Выберите вашу роль:",
                    $vk->getKeyboard()
                );
                break;
        }
    }

}
