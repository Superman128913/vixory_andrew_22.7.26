<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ImplicitRule;

class Phone implements Rule, ImplicitRule
{
    private $notificationsettings = false;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        if(array_key_exists("notificationsettings", $data)) {
            $this->notificationsettings = $data["notificationsettings"];
        }
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(!$value) {
            foreach($this->notificationsettings as $setting)
            {
                if($setting["key"] == "SMS") {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'A phone number is required in order to receive SMS messages.';
    }
}
