<?php

namespace bin\epaphrodite\api\sms;
use bin\epaphrodite\auth\session_auth;
use \Mailjet\Resources;

class send_sms
{
    
  public function sms()
 {   
    // Use your saved credentials, specify that you are using Send API v3.1
    $SENDER_EMAIL="2250708631645";
    $RECIPIENT_EMAIL="2250708631645";
    $token ='44d6fb7ae7c38f949af7f9140d3dc97c26da23c464341310c11bb2f7f3b234ee';
    $mj = new \Mailjet\Client( $token, NULL ,true,['version' => 'v3.1']);
    
    // Define your request body
    
    $body = [
        'Messages' => [
            [
                'From' => [
                    'Email' => "$SENDER_EMAIL",
                    'Name' => "Me"
                ],
                'To' => [
                    [
                        'Email' => "$RECIPIENT_EMAIL",
                        'Name' => "You"
                    ]
                ],
                'Subject' => "My first Mailjet Email!",
                'TextPart' => "Greetings from Mailjet!",
                'HTMLPart' => "<h3>Dear passenger 1, welcome to <a href=\"https://www.mailjet.com/\">Mailjet</a>!</h3>
                <br />May the delivery force be with you!"
            ]
        ]
    ];
    
    // All resources are located in the Resources class
    
    $response = $mj->post(Resources::$Email, ['body' => $body]);
    
    // Read the response
    
    $response->success() && var_dump($response->getData());
}

}
