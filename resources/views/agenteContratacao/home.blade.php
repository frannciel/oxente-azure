<x-app-layout>
    <x-slot name="header">
        <h2 class="w-auto font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Alterar ou Excluir Licitação') }}
        </h2>
    </x-slot>

    <x-component-breadcrumb :breadcrumbs="$breadcrumbs"></x-component-breadcrumb>

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in com perfil de agente de contratação!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
