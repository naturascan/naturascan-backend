<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExportExcelMail extends Mailable
{
    use Queueable, SerializesModels;

    public $filePath;
    public $traceFilePath;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($filePath, $traceFilePath = null)
    {
        $this->filePath = $filePath;
        $this->traceFilePath = $traceFilePath;
    } 

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       $mail = $this->view('emails.export')
                    ->subject('Export Excel File')
                    ->attach($this->filePath, [
                        'as' => 'exports.xlsx',
                        'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
                    ])
                   ;

                    

        if ($this->traceFilePath) {
            $mail->attach($this->traceFilePath, [
                'as' => 'traces.xlsx',
                'mime' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        }

        return $mail;
    }
}
