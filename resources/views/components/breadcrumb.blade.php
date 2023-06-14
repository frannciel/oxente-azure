<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-2">
    <ol class="list-reset flex">
        @foreach($breadcrumbs as $breadcrumb)
            @if(!$loop->last)
                <li>
                    <a href="{{ $breadcrumb['url'] }}" class="text-blue-800 transition duration-150 ease-in-out hover:text-blue-400 focus:text-primary-600 active:text-primary-700 dark:text-primary-400 dark:hover:text-primary-500 dark:focus:text-primary-500 dark:active:text-primary-600">
                        {{ $breadcrumb['title'] }}
                    </a>
                </li>
                <li>
                    <span class="mx-2 text-neutral-500 dark:text-neutral-300">></span>
                </li>
            @else
                <li class="text-neutral-500 dark:text-neutral-300"> {{ $breadcrumb['title'] }}</li>
            @endif
        @endforeach
    </ol>
</div>