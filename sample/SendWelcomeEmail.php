<?php

use IndexIO\Operatur\Worker\Worker;
use IndexIO\Operatur\ProcessType\RunOnTrigger;
use IndexIO\Operatur\Router\Request;

class SendWelcomeEmail extends Worker
{
   use RunOnTrigger;

   const NAME = 'welcome-emails';

   public function handle(Request $request)
   {
        $data = $request->getData();
        $userId = $data['userId'];

        // get user from db and send welcome email
        echo 'it works' . "\n";
   }
}
