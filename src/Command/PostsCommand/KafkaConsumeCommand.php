<?php

namespace App\Command\PostsCommand;

use App\Entity\Post;
use App\Repository\PostRepository;
use Enqueue\RdKafka\RdKafkaConnectionFactory;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

// вызов команды: php bin/console kafka:consume

#[AsCommand(
    name: 'kafka:consume',
    description: 'Консумер для прослушивания сообщений из Kafka'
)]
class KafkaConsumeCommand extends Command
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        parent::__construct();
        $this->postRepository = $postRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);
        $io->success('Консумер запущен и слушает очередь...');

        // Настраиваем подключение к Kafka через фабрику
        $factory = new RdKafkaConnectionFactory([
            'global' => [
                'metadata.broker.list' => 'localhost:9092', // Указываем брокер Kafka
            ],
        ]);

        // Получаем контекст для взаимодействия с Kafka
        $context = $factory->createContext();
        $consumer = $context->createConsumer($context->createQueue('posts_topic'));

        // Запускаем бесконечный цикл прослушивания сообщений
        while (true) {
            $message = $consumer->receive();

            if ($message) {
                // Получаем тело сообщения
                $body = $message->getBody();
                $io->success('Получено сообщение из Kafka: ' . $body);

                // Создаем новый пост и сохраняем его в базу данных
                $post = new Post();
                $post->setBody($body);

                $this->postRepository->save($post);

                $io->success('Сообщение сохранено в базу данных как пост.');

                // Подтверждаем получение сообщения
                $consumer->acknowledge($message);
            }
        }

        return Command::SUCCESS;
    }
}
