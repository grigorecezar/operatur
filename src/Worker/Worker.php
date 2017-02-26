<?php namespace IndexIO\Operatur\Worker;

use IndexIO\Operatur\Contracts\Queue as QueueContract;
use IndexIO\Operatur\Contracts\Worker as WorkerContract;

class Worker implements WorkerContract
{
	protected $queue;

	public function __construct(QueueContract $queue)
	{
		$this->queue = $queue;
	}

	// abstract public function handle($input);
	// abstract public function getListeners();

	/**
     * Generic method being in charged with pulling the right number of messages from the right queue
     * using a custom reservation time based on the individual workers needs
     */
	/* public function getQueueEntries($queue, $messagesBatchSize = 100, $messagesPerWorker = 100, $reserveTime = 60)
	{
		// calculating how many batches are needed to pull all the messages needed
		// this needs to be done because the number of messages pulled in one request is capped at 100
		$numBatches = ceil($messagesPerWorker / $messagesBatchSize);
		$entries = [];
		
		for($i = 1; $i <= $numBatches; $i++){
			$messages = $this->queue->reserveMessages($queue, $messagesBatchSize, $reserveTime);
			if(! $messages) break;

			$entries = array_merge($entries, $messages);
		}

		return $entries;
	}*/
}