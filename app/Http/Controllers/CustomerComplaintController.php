<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\TicketMessage;
use Illuminate\Support\Facades\Auth;

class CustomerComplaintController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();
        $tickets = $user ? Ticket::where('user_id', $user->id)->orderByDesc('created_at')->get() : collect();
        return view('customer.complaints.index', compact('tickets'));
    }

    public function create()
    {
        return view('customer.complaints.create');
    }

    public function store(Request $request)
    {
        $user = $request->user();
        $data = $request->validate([
            'subject' => 'required|string|max:191',
            'description' => 'required|string',
            'priority' => 'nullable|in:low,normal,high',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,txt,doc,docx|max:5120'
        ]);

        $ticket = Ticket::create([
            'user_id' => $user ? $user->id : null,
            'subject' => $data['subject'],
            'description' => $data['description'],
            'priority' => $data['priority'] ?? 'normal',
        ]);

        // handle attachment upload if present
        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('ticket_attachments', 'public');
            $ticket->attachment = $path;
            $ticket->save();
        }

        TicketMessage::create(array_filter([
            'ticket_id' => $ticket->id,
            'user_id' => $user ? $user->id : null,
            'message' => $data['description'],
            'is_admin' => false,
            'attachment' => $ticket->attachment ?? null,
        ]));

        return redirect()->route('complaints')->with('success','Ticket created. Our support will reply shortly.');
    }

    public function show(Request $request, Ticket $ticket)
    {
        $user = $request->user();
        if ($ticket->user_id && (! $user || $ticket->user_id !== $user->id)) {
            abort(403);
        }
        $ticket->load('messages.user');
        return view('customer.complaints.show', compact('ticket'));
    }

    public function reply(Request $request, Ticket $ticket)
    {
        $user = $request->user();
        if ($ticket->user_id && (! $user || $ticket->user_id !== $user->id)) {
            abort(403);
        }
        $data = $request->validate([
            'message' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,txt,doc,docx|max:5120'
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('ticket_attachments', 'public');
        }

        TicketMessage::create(array_filter([
            'ticket_id' => $ticket->id,
            'user_id' => $user ? $user->id : null,
            'message' => $data['message'],
            'is_admin' => false,
            'attachment' => $attachmentPath,
        ]));

        $ticket->status = 'pending';
        $ticket->save();

        return redirect()->route('complaints.show',$ticket)->with('success','Reply sent.');
    }
}
