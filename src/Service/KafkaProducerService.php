<?php

namespace App\Service;

use Enqueue\RdKafka\RdKafkaContext;
use Interop\Queue\Message;
use Interop\Queue\Producer;
use Interop\Queue\Topic;
use Interop\Queue\Context;

class KafkaProducerService
{
    private Context $context;

    public function __construct(Context $context)
    {
        $this->context = $context;
    }

    public function sendMessage(string $topicName, string $body): void
    {
        $topic = $this->context->createTopic($topicName);
        $message = $this->context->createMessage($body);
        $producer = $this->context->createProducer();
        $producer->send($topic, $message);
    }
}
