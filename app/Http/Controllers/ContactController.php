<?php

namespace App\Http\Controllers;

use App\Models\ContactSubmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactFormSubmission;

class ContactController extends Controller
{
   public function index()
{
    $submissions = ContactSubmission::orderBy('created_at', 'desc')->paginate(15);
    return view('admin.contacts.index', compact('submissions')); // <-- compact('submissions') is important
}

   public function show(ContactSubmission $contact)
{
    if (!$contact->is_read) {
        $contact->update(['is_read' => true]);
    }

    return view('admin.contacts.show', compact('contact'));
}

    public function markAsRead(ContactSubmission $contact)
    {
        $contact->update(['is_read' => true]);
        return back()->with('success', 'Marked as read');
    }

    public function destroy(ContactSubmission $contact)
    {
        $contact->delete();
        return redirect()->route('admin.contacts.index')
                         ->with('success', 'Submission deleted');
    }
}
