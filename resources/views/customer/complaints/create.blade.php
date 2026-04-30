<x-layouts.dashboard title="Create Support Ticket">
    <div class="mx-auto w-full max-w-3xl space-y-6 px-2 sm:px-4 lg:px-6">
        <!-- Header Section -->
        <section class="rounded-2xl border border-slate-200 bg-white px-6 py-8 shadow-sm md:px-8">
            <div class="text-center">
                <h1 class="text-3xl font-semibold text-slate-900">Create Support Ticket</h1>
                <p class="mt-2 text-sm text-slate-600">We're here to help. Describe your issue and we'll get back to you as soon as possible.</p>
            </div>
        </section>

        <!-- Form Section -->
        <section class="rounded-2xl border border-slate-200 bg-white shadow-sm">
            <form method="POST" action="{{ route('complaints.store') }}" enctype="multipart/form-data" class="space-y-0">
                @csrf

                <!-- Subject Field -->
                <div class="border-b border-slate-200 px-6 py-6 md:px-8">
                    <label for="subject" class="block text-sm font-semibold text-slate-900">Subject</label>
                    <p class="mt-0.5 text-xs text-slate-600">A brief summary of your issue</p>
                    <input 
                        type="text" 
                        id="subject" 
                        name="subject" 
                        placeholder="e.g., Login issue, Payment problem" 
                        class="mt-3 block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition-colors focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 focus:outline-none @error('subject') border-red-500 @enderror" 
                        required 
                    />
                    @error('subject')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Priority Field -->
                <div class="border-b border-slate-200 px-6 py-6 md:px-8">
                    <label for="priority" class="block text-sm font-semibold text-slate-900">Priority Level</label>
                    <p class="mt-0.5 text-xs text-slate-600">How urgently do you need assistance?</p>
                    <select 
                        id="priority" 
                        name="priority" 
                        class="mt-3 block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition-colors focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 focus:outline-none"
                    >
                        <option value="low">Low - Non-urgent, informational</option>
                        <option value="normal" selected>Normal - Standard support needed</option>
                        <option value="high">High - Urgent assistance required</option>
                    </select>
                    @error('priority')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Message Field -->
                <div class="border-b border-slate-200 px-6 py-6 md:px-8">
                    <label for="description" class="block text-sm font-semibold text-slate-900">Message Details</label>
                    <p class="mt-0.5 text-xs text-slate-600">Please provide detailed information about your issue</p>
                    <textarea 
                        id="description" 
                        name="description" 
                        rows="7" 
                        placeholder="Describe what happened, steps you took, and any error messages you received..." 
                        class="mt-3 block w-full rounded-lg border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 shadow-sm transition-colors focus:border-cyan-500 focus:ring-1 focus:ring-cyan-500 focus:outline-none @error('description') border-red-500 @enderror" 
                        required
                    ></textarea>
                    @error('description')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Attachment Field -->
                <div class="px-6 py-6 md:px-8">
                    <label for="attachment" class="block text-sm font-semibold text-slate-900">Attachment (Optional)</label>
                    <p class="mt-0.5 text-xs text-slate-600">Upload screenshots, documents, or other supporting files</p>
                    
                    <div class="mt-4 rounded-lg border-2 border-dashed border-slate-300 bg-slate-50 p-6 text-center transition-colors hover:border-cyan-400 hover:bg-cyan-50 focus-within:border-cyan-500 focus-within:bg-cyan-50">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="h-12 w-12 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                            </svg>
                            <p class="mt-3 text-sm font-medium text-slate-900">Drag and drop your file here</p>
                            <p class="mt-1 text-xs text-slate-600">or</p>
                            <label for="attachment" class="mt-2 inline-flex cursor-pointer items-center text-sm font-semibold text-cyan-600 hover:text-cyan-700">Browse Files</label>
                        </div>
                        <input 
                            type="file" 
                            id="attachment" 
                            name="attachment" 
                            accept=".jpg,.jpeg,.png,.gif,.pdf,.txt,.doc,.docx" 
                            class="hidden" 
                        />
                    </div>
                    <p class="mt-3 text-xs text-slate-600">Max file size: <span class="font-semibold">5 MB</span>. Allowed formats: <span class="font-semibold">JPG, PNG, GIF, PDF, TXT, DOC, DOCX</span></p>
                    @error('attachment')
                        <p class="mt-2 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-3 border-t border-slate-200 px-6 py-6 md:px-8">
                    <button 
                        type="submit" 
                        class="inline-flex items-center justify-center rounded-full bg-cyan-600 px-8 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-white shadow-sm transition-all hover:bg-cyan-700 active:scale-95"
                    >
                        Create Ticket
                    </button>
                    <a 
                        href="{{ route('complaints') }}" 
                        class="inline-flex items-center justify-center rounded-full border border-slate-300 px-8 py-3 text-sm font-semibold uppercase tracking-[0.12em] text-slate-700 transition-colors hover:bg-slate-50"
                    >
                        Cancel
                    </a>
                </div>
            </form>
        </section>
    </div>
</x-layouts.dashboard>
