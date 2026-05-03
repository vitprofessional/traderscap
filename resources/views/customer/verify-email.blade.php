<x-layouts.dashboard title="Verify Email Address">

    <div class="mx-auto w-full max-w-2xl space-y-6 px-2 sm:px-4 lg:px-6">

        <!-- Page header -->
        <section class="rounded-2xl border border-slate-200 bg-white px-6 py-8 shadow-sm md:px-8">
            <h1 class="text-3xl font-bold text-slate-900">Verify Your Email</h1>
            <p class="mt-2 text-sm text-slate-600">One quick step to secure your account.</p>
        </section>

        <!-- Notice card -->
        <section class="rounded-2xl border border-amber-200 bg-amber-50 shadow-sm overflow-hidden">
            <div class="flex items-start gap-4 px-6 py-6 md:px-8">
                <div class="mt-0.5 flex-shrink-0 rounded-full bg-amber-100 p-2">
                    <svg class="h-6 w-6 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <h2 class="text-base font-semibold text-amber-900">Please verify your email address</h2>
                    <p class="mt-1.5 text-sm text-amber-800 leading-relaxed">
                        We sent a verification link to
                        <span class="font-semibold">{{ auth()->user()->email }}</span>.
                        Click the link in that email to verify your account.
                    </p>
                    <p class="mt-1 text-xs text-amber-700">If you don't see it, check your spam or junk folder.</p>
                </div>
            </div>
        </section>

        <!-- Feedback messages -->
        @if(session('resend_success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-6 py-4">
                <div class="flex items-center gap-3">
                    <svg class="h-5 w-5 flex-shrink-0 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-sm font-semibold text-emerald-800">{{ session('resend_success') }}</p>
                </div>
            </div>
        @endif

        @if(session('resend_info'))
            <div class="rounded-xl border border-sky-200 bg-sky-50 px-6 py-4">
                <p class="text-sm font-semibold text-sky-800">{{ session('resend_info') }}</p>
            </div>
        @endif

        <!-- Action card -->
        <section class="rounded-2xl border border-slate-200 bg-white shadow-sm overflow-hidden">
            <div class="border-b border-slate-200 px-6 py-5 md:px-8">
                <h3 class="text-sm font-semibold text-slate-700">Didn't receive the email?</h3>
            </div>
            <div class="flex flex-wrap items-center gap-3 px-6 py-6 md:px-8">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-lg bg-cyan-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm ring-1 ring-cyan-600 transition-all hover:bg-cyan-700 hover:ring-cyan-700 active:scale-[0.97] focus:outline-none focus:ring-2 focus:ring-cyan-400 focus:ring-offset-2">
                        <svg class="h-4 w-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                        </svg>
                        Resend Verification Email
                    </button>
                </form>

                <a href="{{ route('profile') }}"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-6 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition-all hover:bg-slate-50 hover:border-slate-400 active:scale-[0.97] focus:outline-none focus:ring-2 focus:ring-slate-300 focus:ring-offset-2">
                    Back to Profile
                </a>
            </div>
        </section>

    </div>

</x-layouts.dashboard>
