<?php

use IndexIO\Operatur\Worker\Worker;
use IndexIO\Operatur\ProcessType\RunOnSchedule;
use IndexIO\Operatur\Router\Request;

/**
 * Cron definition is {second} {minute} {hour} {day} {month} {day of the week}
 * We define all these as a static array. Each Function that uses RunOnSchedule must have one.
 */
class SendDailyUpdatesEmail extends Worker
{
   use RunOnSchedule;

   const NAME = 'daily-updates';

   /**
    * This means the function will run every day at 10AM UTC
    */
   const RUN_EVERY = [
       'second' => 0,
       'minute' => 0,
       'hour' => 10,
       'day' => '*',
       'month' => '*',
       'day-of-week' => '*'
   ];

   public function run(Request $request)
   {
        // $data = $request->getData();
        // $userId = $data['userId'];

        // get user from db and send welcome email
        echo 'it works' . "\n";
   }
}
