<x-layout>
    <nav class="max-w-7xl mx-auto bg-white p-8 md:flex md:items-center md:justify-between ">
        <div class="flex justify-between items-center">
            <span>
                <a href="{{ $path }}">
                    <img class="h-10 w-auto inline" src="{{ asset('images/logo.png') }}" alt="Workflow">
                </a>

            </span>

            <a class="px-2 py-1 md:hidden"
                href="{{ Config::get('app.locale') === 'en' ? route('locale.setting', 'ka') : route('locale.setting', 'en') }}">
                {{ Config::get('app.locale') === 'ka' ? 'ქართული' : 'English' }}
            </a>

            <x-dashboard.dropdown />

        </div>

        <ul
            class="md:flex md:items-center z-[-1] md:z-auto md:static absolute bg-white w-full
            left-0 md:w-auto md:py-0 py-4 md:pl-0 pl-7 md:opacity-100 opacity-0">
            <li class="mx-4 my-6 md:my-0 ">
                <a href="
                {{ Config::get('app.locale') === 'en' ? route('locale.setting', 'ka') : route('locale.setting', 'en') }}"
                    class="text-lg hover:text-green-600 flex items-center">
                    {{ Config::get('app.locale') === 'ka' ? 'ქართული' : 'English' }}
                    <x-svg.arrow-svg />
                </a>
            </li>
            <li class="mx-4  my-6 md:my-0">
                <a href=" {{ route('locale.setting', 'en') }}"
                    class="text-lg font-extrabold hover:text-green-600">{{ auth()->user()->username }}.</a>
            </li>
            <li class="mx-4  my-6 md:my-0">
                <a class=" text-lg hover:text-green-600">
                    <form action="/logout" method="POST">
                        @csrf
                        <button type="submit">{{ __('message.log_out') }}</button>
                    </form>
                </a>
            </li>

        </ul>
    </nav>


</x-layout>
