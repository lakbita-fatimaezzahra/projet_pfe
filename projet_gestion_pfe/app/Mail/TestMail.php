<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TestMail extends Mailable
{
    use Queueable, SerializesModels;

    public $title;
    public $body;
    public $filePath;

    public function __construct($title, $body, $filePath)
    {
        $this->title = $title;
        $this->body = $body;
        $this->filePath = $filePath;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Test Mail'
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'prof.test',
            with: [
                'title' => $this->title,
                'body' => $this->body,
            ]
        );
    }

    /**
     * Build the email and attach the file
     *
     * @return $this
     */
    public function build()
    {
        $mail = $this->subject('Test Mail')
            ->view('prof.test')
            ->with([
                'title' => $this->title,
                'body' => $this->body,
            ]);

        // Attach the file
        $mail->attach(storage_path('app/public/' . $this->filePath), [
            'as' => basename($this->filePath),
            'mime' => 'application/pdf', // Adjust MIME type as needed
        ]);

        return $mail;
    }
}
