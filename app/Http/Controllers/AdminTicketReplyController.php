<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Ticket;
use App\Models\TicketMessage;

class AdminTicketReplyController extends Controller
{
    public function store(Request $request, Ticket $ticket)
    {
        $this->validate($request, [
            'message' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,pdf,txt,doc,docx|max:5120',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            try {
                $attachmentPath = $request->file('attachment')->store('ticket_attachments', 'public');
            } catch (\Throwable $e) {
                logger()->error('AdminTicketReplyController: failed to store attachment: '.$e->getMessage(), ['ticket_id' => $ticket->id]);
                return back()->withErrors(['attachment' => 'Failed to upload attachment.']);
            }
        }

        $message = TicketMessage::create([
            'ticket_id' => $ticket->id,
            'user_id' => null,
            'message' => $request->input('message') ?: null,
            'is_admin' => true,
            'attachment' => $attachmentPath,
        ]);

        $ticket->status = 'open';
        $ticket->save();

        try {
            if ($ticket->user) {
                $ticket->user->notify(new \App\Notifications\NewTicketReply($message));
            }
        } catch (\Throwable $e) {
            logger()->error('AdminTicketReplyController: notify failed: '.$e->getMessage(), ['ticket_id' => $ticket->id]);
        }

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['message' => 'Reply posted.'], 200);
        }

        return back()->with('success', 'Reply posted.');
    }
}
