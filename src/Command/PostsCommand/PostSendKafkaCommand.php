<?php

namespace App\Command\PostsCommand;

use App\Service\KafkaProducerService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

// вызов команды: php bin/console post:send-kafka

#[AsCommand(
    name: 'post:send-kafka',
    description: 'отправка сообщения в Kafka',
)]
class PostSendKafkaCommand extends Command
{
    private KafkaProducerService $kafkaProducerService;

    public function __construct(KafkaProducerService $kafkaProducerService)
    {
        parent::__construct();
        $this->kafkaProducerService = $kafkaProducerService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        // Получаем содержание поста от пользователя
        $body = $io->ask('Введите содержание поста');

        if (!$body) {
            $io->error('Содержание поста не может быть пустым!');
            return Command::FAILURE;
        }

        // Отправляем сообщение с содержимым поста в Kafka
        $this->kafkaProducerService->sendMessage('posts_topic', $body);

        $io->success('Сообщение с текстом поста отправлено в Kafka успешно!');

        return Command::SUCCESS;
    }
}
