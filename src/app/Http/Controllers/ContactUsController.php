<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContactFormRequest;
use App\Models\Recipient;
use App\Notifications\ContactFormMessage;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    /**
     * Display the contact us page.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contact-us');
    }

    public function mailContactForm(ContactFormRequest $message, Recipient $recipient)
    {
        $recipient->notify(new ContactFormMessage($message));

        return redirect()->back()->with('message', 'Thanks for your message! We will get back to you soon!');
    }
}
