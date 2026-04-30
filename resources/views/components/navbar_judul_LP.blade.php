<nav class="flex items-center justify-between px-6 py-3 bg-white border border-[#d7e6de] rounded-2xl shadow-sm">
        
        <div class="flex items-center gap-2">
            <span class="text-[#22543D] text-[10px] font-bold uppercase tracking-widest">
                {{ $NavParent ?? 'Management Rental' }}
            </span>
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="#22543D" stroke-width="3">
                <path d="M9 18l6-6-6-6" />
            </svg>
            <span class="text-[#ED64A6] text-[10px] font-bold uppercase tracking-widest">
                {{ $section ?? 'Kamera' }}
            </span>
        </div>

        

        <div class="flex items-center gap-4">
            <div class="relative hidden md:block">
                <span class="absolute inset-y-0 left-3 flex items-center text-[#22543D]">
                </span>

                
            </div>
        </div>
    </nav>