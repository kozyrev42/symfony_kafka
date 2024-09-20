<?php

namespace App\Command\PostsCommand;

use App\Repository\PostRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

// вызов команды: php bin/console post:create

#[AsCommand(
    name: 'post:create',
    description: 'Создать новый пост'
)]
class PostCreateCommand extends Command
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        parent::__construct();
        $this->postRepository = $postRepository;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $body = $io->ask('Введите содержание поста');

        if (!$body) {
            $io->error('Название и содержание поста не могут быть пустыми!');
            return Command::FAILURE;
        }

        $post = new \App\Entity\Post();
        $post->setBody($body);

        $this->postRepository->save($post);

        $io->success('Пост создан успешно!');

        return Command::SUCCESS;
    }
}
