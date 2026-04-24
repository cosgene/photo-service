<?php

require_once __DIR__ . '/../Services/VkService.php';
require_once __DIR__ . '/../Core/Database.php';
require_once __DIR__ . '/../Core/Logger.php';
require_once __DIR__ . '/../Repositories/UserRepository.php';

class BotController {

    public function handle() {

        $input = file_get_contents('php://input');

        Logger::log('raw.log', $input);

        $data = json_decode($input, true);

        if (!$data) {
            Logger::log('error.log', 'NO JSON DATA');
            echo "ok";
            return;
        }

        Logger::log('vk_incoming.log', $data);

        if (!isset($data['type'])) {
            Logger::log('error.log', 'NO TYPE');
            echo "ok";
            return;
        }

        if ($data['type'] === 'confirmation') {
            Logger::log('callback.log', 'CONFIRMATION');
            echo '43b4e0f4';
            return;
        }

        if ($data['type'] === 'message_new') {
            $message = $data['object']['message'] ?? null;

            if (!$message) {
                Logger::log('error.log', 'EMPTY MESSAGE OBJECT');
                echo "ok";
                return;
            }

            Logger::log('messages.log', $message);

            $this->handleMessage($message);
        }

        echo 'ok';
    }

    private function handleMessage($message) {

        $vkId = $message['from_id'] ?? null;
        $text = trim($message['text'] ?? '');

        if (!$vkId) return;

        $vk = new VkService();
        $users = new UserRepository();

        $user = $users->findByVkId($vkId);

        // 1. create user
        if (!$user) {
            $users->create($vkId);

            $vk->sendMessage(
                $vkId,
                "Привет! Выберите роль:",
                $vk->getKeyboard()
            );
            return;
        }

        // 2. ROLE NOT SET → ONLY HERE HANDLE ROLE SELECTION
        if (empty($user['role'])) {

            if ($text === 'Фотограф') {
                $users->setRole($vkId, 'photographer');
                $vk->sendMessage($vkId, "📸 Вы вошли как фотограф", null);
                return;
            }

            if ($text === 'Родитель') {
                $users->setRole($vkId, 'parent');
                $vk->sendMessage($vkId, "👨‍👩‍👧 Вы вошли как родитель", null);
                return;
            }

            // ВСЁ ОСТАЛЬНОЕ НЕ ТРИГГЕРИТ РОЛЬ
            $vk->sendMessage(
                $vkId,
                "Выберите роль:",
                $vk->getKeyboard()
            );
            return;
        }

        // 3. ROLE SET → NORMAL CHAT MODE

        $role = $user['role'];

        if ($role === 'photographer') {

            if ($text === '/menu') {
                $vk->sendMessage($vkId, "📸 Меню фотографа", $vk->getKeyboard());
                return;
            }

            $vk->sendMessage($vkId, "📸 Вы фотограф. Команда /menu");
            return;
        }

        if ($role === 'parent') {

            if ($text === '/menu') {
                $vk->sendMessage($vkId, "👨‍👩‍👧 Меню родителя");
                return;
            }

            $vk->sendMessage($vkId, "👨‍👩‍👧 Вы родитель. Команда /menu");
            return;
        }
    }

}
