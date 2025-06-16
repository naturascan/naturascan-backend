@foreach($navigation as $group => $resources)
    @if (count($groups) > 1)
        <h3 class="flex items-center font-normal text-white mb-6 text-base no-underline">
            @if ($group == 'Utilisateurs')
                <svg class="sidebar-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                          d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>

            @elseif ($group == 'Défis & Cadeaux')
                <svg class="sidebar-icon w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                          d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                </svg>
            @elseif($group == 'Pays & ville')
                <svg class="sidebar-icon w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                     xmlns="http://www.w3.org/2000/svg">
                    <path
                          d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
{{--            @elseif($group == 'News Coseka')--}}
{{--                <svg class="sidebar-icon w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"--}}
{{--                     xmlns="http://www.w3.org/2000/svg">--}}
{{--                    <path fill="var(--sidebar-icon)"--}}
{{--                          d="M3 19v-8.93a2 2 0 01.89-1.664l7-4.666a2 2 0 012.22 0l7 4.666A2 2 0 0121 10.07V19M3 19a2 2 0 002 2h14a2 2 0 002-2M3 19l6.75-4.5M21 19l-6.75-4.5M3 10l6.75 4.5M21 10l-6.75 4.5m0 0l-1.14.76a2 2 0 01-2.22 0l-1.14-.76"></path>--}}
{{--                </svg>--}}
            @else
                <svg class="sidebar-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path fill="var(--sidebar-icon)"
                          d="M3 1h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2V3c0-1.1045695.8954305-2 2-2zm0 2v4h4V3h-4zM3 11h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2H3c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4H3zm10-2h4c1.1045695 0 2 .8954305 2 2v4c0 1.1045695-.8954305 2-2 2h-4c-1.1045695 0-2-.8954305-2-2v-4c0-1.1045695.8954305-2 2-2zm0 2v4h4v-4h-4z"
                    />
                </svg>
            @endif
            <span class="sidebar-label">{{ $group }}</span>
        </h3>
    @endif

    <ul class="list-reset mb-8">
        @foreach($resources as $resource)
            <li class="leading-tight mb-4 ml-8 text-sm">
                <router-link :to="{
                    name: 'index',
                    params: {
                    resourceName: '{{ $resource::uriKey() }}'
                    }
                    }" class="text-white text-justify no-underline dim" dusk="{{ $resource::uriKey() }}-resource-link">
                    {{ $resource::label() }}
                </router-link>
            </li>
        @endforeach
    </ul>
@endforeach

