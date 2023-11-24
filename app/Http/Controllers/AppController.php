<?php

namespace App\Http\Controllers;

use App\Mail\DocumentSigning;
use App\Models\EmailAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AppController extends Controller
{
    public function index()
    {
        $totalMails = EmailAddress::count();
        $queueMails = DB::table('jobs')->count();
        $failedJobs = DB::table('failed_jobs')->count();
        $totalSentMails = $totalMails - $failedJobs;

        return view('dashboard', compact('totalMails', 'totalSentMails', 'queueMails', 'failedJobs'));
    }

    // send emails
    public function sendIndex()
    {
        return view('sendMails');
    }

    public function sendMails(Request $request)
    {
        $this->validate($request, ['emails' => 'required|string']);

        $emails = explode(',', $request->emails);

        foreach ($emails as $key => $email) {

            EmailAddress::create(['email' => $email]);

            Mail::to($email)->queue(new DocumentSigning($email));
        }

        session()->flash("success", "Mails Queued for sendinf");

        return redirect()->back();
    }

    public function viewTemplate(): DocumentSigning
    {
        $email = "test@test.com";

        return new DocumentSigning($email);
    }
}
