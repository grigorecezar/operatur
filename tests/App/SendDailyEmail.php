<?php namespace IndexIO\Operatur\Test\App;

use IndexIO\Operatur\Worker\Worker;
use IndexIO\Operatur\ProcessType\MasterSlave;
use IndexIO\Operatur\Router\Request;

class SendDailyEmail extends Worker
{
   use MasterSlave;

   const NAME = 'daily-activity-emails';
   const QUEUE_NAME = '/daily-emails';
   /* public $scheduler = [
        [
            'process' => 'master',
            'start-time' => time(),
            'label' => 'Master',
            'run-every' => 120 // seconds
        ]
   ];*/

   public function master(Request $request)
   {
       // connect to the database and pull all user ids
       // split the user ids into 100's and push the data back to the queue
       // for the slave processes
       // we will just hardcode the ids here;

       $userIds = [];
       for ($i = 1; $i <= 1000; $i++) {
           $userIds[] = $i;

           if ( (count($userIds) + 1) % 100 === 0) {
               $this->queue->run($this, new Request(['userIds' => $userIds]), 'slave');
               $userIds = [];
           }
       }
   }

   public function slave(Request $request)
   {
        $data = $request->getData();
        $userIds = $data['userIds'];

        foreach ($userIds as $id) {
            // eg. pull the user from db and send custom email
            echo 'email user with id: ' . $id . "\n";
        }
   }
}
