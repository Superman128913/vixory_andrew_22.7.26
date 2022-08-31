<?php 
namespace App\Domain\Mailchimp;

use \MailchimpMarketing\ApiClient;
use \Log;

class Connector 
{
    protected $client;
    protected $list_id;

    public function __construct()
    {
        $this->client = new ApiClient();

        $this->client->setConfig([
          'apiKey' => config('services.mailchimp.api_key'),
          'server' => config('services.mailchimp.server_prefix')
        ]);
        
        $this->list_id = config('services.mailchimp.default_list');
    }

    public function addUser($email, $first_name, $last_name, $tag)
    {
        try
        {
            //Create the user
            $response = $this->client->lists->addListMember($this->list_id, [
                "email_address" => $email,
                "status" => "subscribed",
                "merge_fields" => [
                  "FNAME" => $first_name,
                  "LNAME" => $last_name
                ]
            ]);

            //Tag the user
            $subscriber_hash = md5(strtolower($email));
            $this->client->lists->updateListMemberTags($this->list_id, $subscriber_hash, [
                "tags" => [
                    [
                        "name"      => $tag,
                        "status"    => "active"
                    ]
                ]
            ]);

        }
        catch(\Exception $e) {
            $message = $e->getResponse()->getBody()->getContents();
            Log::error($e->getResponse()->getBody()->getContents());
        }
    }
}