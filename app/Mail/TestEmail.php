<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TestEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $subject = 'This is a demo!';

        $headerData = [
//            'unique_args' => [
//                'variable_1' => 'abc'
//            ]
            'sub' => [
                '%recipient_name%' => [$this->data['name']],
                '%sender_name%' => [$this->data['sender_name']],
//                '%message%' => [$this->data['message']],
//                '%href_created_video%' => ['https://wordswontdo.com/my-videos/john-leonardo-da-vinci-3']
            ],
            'filters' => [
                'templates' => [
                    'settings' => [
                        'enable' => 1,
                        'template_id' => 'ca27e582-4c9c-4871-bd34-e699d21f3171'
                    ]
                ]
            ]
        ];

//%href_created_video%
        //http://www.watch.com
        $header = $this->asString($headerData);

        $this->withSwiftMessage(function ($message) use ($header) {
            $message->getHeaders()
                ->addTextHeader('X-SMTPAPI', $header);
        });

        return $this->view('emails.test')
            ->subject($subject);
    }

    private function asJSON($data)
    {
        $json = json_encode($data);
        $json = preg_replace('/(["\]}])([,:])(["\[{])/', '$1$2 $3', $json);

        return $json;
    }


    private function asString($data)
    {
        $json = $this->asJSON($data);

        return wordwrap($json, 76, "\n   ");
    }
}
