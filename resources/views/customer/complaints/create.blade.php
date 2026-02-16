<x-layouts.dashboard title="Create Ticket">
    <div class="max-w-2xl w-full">
        <h1 class="text-xl font-semibold mb-4">Create Support Ticket</h1>

        <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label class="block text-sm font-medium">Subject</label>
                <input name="subject" class="mt-1 block w-full border rounded p-2" required />
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Priority</label>
                <select name="priority" class="mt-1 block w-full border rounded p-2">
                    <option value="normal">Normal</option>
                    <option value="low">Low</option>
                    <option value="high">High</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Message</label>
                <textarea name="description" rows="6" class="mt-1 block w-full border rounded p-2" required></textarea>
            </div>

            <div class="mb-3">
                <label class="block text-sm font-medium">Attachment (optional)</label>
                <input type="file" name="attachment" class="mt-1 block w-full" accept=".jpg,.jpeg,.png,.gif,.pdf,.txt,.doc,.docx" />
                <p class="text-xs text-gray-500 mt-1">Max 5MB. Allowed: jpg, jpeg, png, gif, pdf, txt, doc, docx.</p>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded">Create Ticket</button>
                <a href="{{ route('complaints') }}" class="px-4 py-2 border rounded">Cancel</a>
            </div>
        </form>
    </div>
</x-layouts.dashboard>
