{{-- Contact: left column with heading and contact details, right column with the form.
     The form keeps the same dark look as before. Honeypot, CSRF and contact.store route are unchanged. --}}
@php
    $inputClass = 'w-full rounded-xl border border-white/15 bg-black/80 px-4 py-3.5 text-sm text-white placeholder-[#737373] transition focus:border-white focus:bg-black focus:outline-none';
    $hasContact = filled($profile->email) || filled($profile->phone) || filled($profile->location);
@endphp

<section id="contact" class="relative border-t border-white/10 bg-transparent py-24 md:py-32">
    <div aria-hidden="true" class="pointer-events-none absolute inset-0 bg-gradient-to-b from-transparent via-black/20 to-black/35"></div>

    <div class="relative mx-auto w-full max-w-[1400px] px-5 sm:px-7 lg:px-10">
        <div class="grid grid-cols-1 gap-12 lg:grid-cols-12 lg:gap-16" data-reveal>

            {{-- Left: heading and contact details --}}
            <div class="lg:col-span-5">
                <p class="mb-3 text-xs font-medium uppercase tracking-[0.2em] text-[#A3A3A3]">Get In Touch</p>
                <h2 class="mb-5 font-display text-3xl font-bold text-white md:text-4xl lg:text-5xl" style="text-wrap: balance;">Let's Create Something Amazing.</h2>
                <p class="mb-10 text-base leading-relaxed text-[#A3A3A3]">Have an idea, opportunity, or project in mind? Let's connect and build something meaningful together.</p>

                @if ($hasContact)
                    <div class="space-y-5">
                        @if (filled($profile->email))
                            <a href="mailto:{{ $profile->email }}" class="flex items-center gap-4 text-white transition hover:text-[#D4D4D4]">
                                <x-icon name="mail" class="h-5 w-5 text-white" hover="none" />
                                <span>{{ $profile->email }}</span>
                            </a>
                        @endif

                        @if (filled($profile->phone))
                            <a href="tel:{{ preg_replace('/\s+/', '', $profile->phone) }}" class="flex items-center gap-4 text-white transition hover:text-[#D4D4D4]">
                                <x-icon name="phone" class="h-5 w-5 text-white" hover="none" />
                                <span>{{ $profile->phone }}</span>
                            </a>
                        @endif

                        @if (filled($profile->location))
                            <div class="flex items-center gap-4 text-white">
                                <x-icon name="map-pin" class="h-5 w-5 text-white" hover="none" />
                                <span>{{ $profile->location }}</span>
                            </div>
                        @endif
                    </div>
                @endif

                <div class="mt-10 flex items-center gap-3">
                    @if (filled($profile->linkedin))
                        <a href="{{ $profile->linkedin }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-lg border border-white/15 bg-white/5 px-4 py-2.5 text-sm text-white transition hover:bg-white/10">
                            <x-icon name="linkedin" class="h-4 w-4 text-white" hover="none" />
                            <span>LinkedIn</span>
                        </a>
                    @endif
                    @if (filled($profile->github))
                        <a href="{{ $profile->github }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 rounded-lg border border-white/15 bg-white/5 px-4 py-2.5 text-sm text-white transition hover:bg-white/10">
                            <x-icon name="github" class="h-4 w-4 text-white" hover="none" />
                            <span>GitHub</span>
                        </a>
                    @endif
                </div>
            </div>

            {{-- Right: form (same dark look as before) --}}
            <div class="lg:col-span-7">
                @if (session('success'))
                    <div class="mb-6 flex items-start gap-3 rounded-xl border border-emerald-400/40 bg-emerald-400/10 p-4 text-sm text-emerald-200">
                        <x-icon name="circle-check" class="h-5 w-5 shrink-0" hover="none" />
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                <form method="POST" action="{{ route('contact.store') }}" novalidate class="space-y-5 rounded-2xl border border-white/10 bg-[#0A0A0A]/90 p-6 backdrop-blur md:p-8">
                    @csrf

                    {{-- Honeypot: hidden from people, bots fill it in --}}
                    <div class="absolute -left-[9999px] h-0 w-0 overflow-hidden" aria-hidden="true">
                        <label for="website">Website</label>
                        <input id="website" type="text" name="website" tabindex="-1" autocomplete="off" />
                    </div>

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
                        <div>
                            <label for="full_name" class="mb-2 block text-sm font-medium text-white">Full Name</label>
                            <input id="full_name" name="full_name" type="text" value="{{ old('full_name') }}" placeholder="Your full name" class="{{ $inputClass }}" />
                            @error('full_name') <p class="mt-1.5 text-xs text-[#D4D4D4]">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label for="email" class="mb-2 block text-sm font-medium text-white">Email</label>
                            <input id="email" name="email" type="email" value="{{ old('email') }}" placeholder="you@example.com" class="{{ $inputClass }}" />
                            @error('email') <p class="mt-1.5 text-xs text-[#D4D4D4]">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="subject" class="mb-2 block text-sm font-medium text-white">Subject</label>
                        <input id="subject" name="subject" type="text" value="{{ old('subject') }}" placeholder="Project inquiry, opportunity, or collaboration" class="{{ $inputClass }}" />
                        @error('subject') <p class="mt-1.5 text-xs text-[#D4D4D4]">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="message" class="mb-2 block text-sm font-medium text-white">Message</label>
                        <textarea id="message" name="message" rows="6" placeholder="Tell me about your project or opportunity..." class="{{ $inputClass }} resize-y">{{ old('message') }}</textarea>
                        @error('message') <p class="mt-1.5 text-xs text-[#D4D4D4]">{{ $message }}</p> @enderror
                    </div>

                    @error('website') <p class="text-xs text-[#D4D4D4]">{{ $message }}</p> @enderror

                    <button type="submit" class="inline-flex cursor-pointer items-center gap-2.5 rounded-lg bg-white px-6 py-3.5 text-sm font-semibold text-black shadow-[0_0_24px_rgba(255,255,255,0.12)] transition hover:bg-[#E5E5E5] hover:shadow-[0_0_32px_rgba(255,255,255,0.2)]">
                        <span>Send Message</span>
                        <x-icon name="send" class="h-4 w-4 text-black" hover="none" />
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>