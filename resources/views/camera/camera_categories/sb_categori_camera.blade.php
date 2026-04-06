<aside class="w-56 flex-shrink-0 pt-2">

    {{-- Sort --}}
    <div class="mb-6">
        <p class="section-label">Sort by</p>
        <select class="sort-select w-full">
            <option>Recommended</option>
            <option>Price: Low to High</option>
            <option>Price: High to Low</option>
            <option>Newest</option>
        </select>
    </div>

    <div class="sidebar-divider"></div>

    {{-- Category --}}
    <div>
        <p class="section-label">Category</p>
        <div>
            @foreach(['DSLR','Mirrorless','Action Camera','Instant Camera (Polaroid)','Camcorder'] as $cat)
            <input type="checkbox" class="filter-checkbox" id="cat-{{ Str::slug($cat) }}">
            <label class="filter-label" for="cat-{{ Str::slug($cat) }}">
                <span class="custom-check"></span>
                {{ $cat }}
            </label>
            @endforeach
        </div>
    </div>

    <div class="sidebar-divider"></div>

    {{-- IP Category - gaya Popmart grid --}}
    <div>
        <p class="section-label">IP Category</p>

        <div class="grid grid-cols-3 gap-1.5" id="ipGrid">
            @foreach($ipCategories as $i => $ip)
            <div class="ip-card {{ $i >= 6 ? 'ip-extra hidden' : '' }} cursor-pointer text-center"
                 onclick="this.classList.toggle('ip-active')">
                <div class="ip-card-box aspect-square rounded-lg border border-gray-200 bg-white
                            flex items-center justify-center overflow-hidden
                            transition-all duration-200">
                    <img src="{{ $ip->image ? asset('storage/'.$ip->image) : 'https://placehold.co/60x60/e8e7e3/aaa?text='.urlencode(Str::limit($ip->name,3,'')) }}"
                         alt="{{ $ip->name }}"
                         class="w-4/5 h-4/5 object-contain">
                </div>
                <p class="ip-card-name mt-1 text-gray-400 font-semibold leading-tight"
                   style="font-size:9px; letter-spacing:.04em;">
                    {{ Str::upper($ip->name) }}
                </p>
            </div>
            @endforeach
        </div>

        @if(count($ipCategories) > 6)
        <button id="btnMore"
                onclick="toggleMore()"
                class="mt-2 w-full py-1.5 text-xs font-semibold tracking-widest uppercase
                       text-gray-400 border border-gray-200 rounded-md
                       hover:border-gray-400 hover:text-gray-600 transition">
            + More
        </button>
        @endif
    </div>

    <div class="sidebar-divider"></div>

    {{-- Price Range --}}
    <div>
        <p class="section-label">Price Range</p>
        <div class="flex gap-2 mt-2">
            <input type="number" placeholder="Min"
                   class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded-md bg-white
                          focus:outline-none focus:border-gray-500">
            <input type="number" placeholder="Max"
                   class="w-full px-2 py-1.5 text-xs border border-gray-300 rounded-md bg-white
                          focus:outline-none focus:border-gray-500">
        </div>
        <button class="mt-3 w-full py-2 text-xs font-semibold tracking-widest uppercase
                       bg-gray-900 text-white rounded-md hover:bg-gray-700 transition">
            Apply
        </button>
    </div>

</aside>