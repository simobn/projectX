<?php
namespace app\Models;
use app\Core\Model;

/**
 * Class ContactForm
 * @package app\Models
 * @author mohammedd benouijem <mbenouijem@gmail.com>
 */

class ContactForm extends Model
{
    public string $subject = '';
    public string $email = '';
    public string $body = '';

    public function rules(): array
    {
        return [
            'subject' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED,self::RULE_EMAIL],
            'body'  =>  [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array
    {
        return [
            'subject'    =>  'your subject',
            'email'    =>  'your email',
            'body'    =>  'your body',
        ];
    }

    public function send()
    {
        return true;
    }
}