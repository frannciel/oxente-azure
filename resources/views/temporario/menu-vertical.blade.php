
    <ul id="nav" class="m-0 z-50 mt-2 p-0 list-none w-40 rounded-lg shadow-lg">
        <li class=" relative"><a href="#" class=" block bg-white p-1 border-l border-solid text-emerald-800 border-gray-500">Licitação</a></li>
        <li class=" relative"><a href="#" class=" block bg-white p-1 border-l border-solid text-emerald-800 border-gray-500">Contratação Direta</a></li>
        <li class=" relative"><a href="#" class=" block bg-white p-1 border-l border-solid text-emerald-800 border-gray-500">Fornecedor</a></li>
        <li  class="relative">
            <div x-data="{ open: false }" @mouseenter="open = true" @click.outside="open = false" @close.stop="open = false"  @mouseout="open = ! open">
                Requisição
                <ul class="absolute left-40 top-0" x-show="open" x-transition>
                    <li><a href="#" class=" block bg-white p-1 border-l border-solid text-emerald-800 border-gray-500">Web Design</a></li>
                    <li><a href="#" class=" block bg-white p-1 border-l border-solid text-emerald-800 border-gray-500">Hospedagem</a></li>
                    <li><a href="#" class=" block bg-white p-1 border-l border-solid text-emerald-800 border-gray-500">SEO</a></li>
                    <li><a href="#"class=" block bg-white p-1 border-l border-solid text-emerald-800 border-gray-500">Sistemas</a></li>
                </ul>
            </div>
        </li>
        <li class=" relative"><a href="#" class=" block bg-white p-1 border-l border-solid text-emerald-800 border-gray-500">Contato</a></li>
        <li class="relative">
            <div x-data="{ open: false }" @mouseenter="open = true" @click.outside="open = false" @mouseout="open = ! open">
                Contratação
                <div class="absolute left-40 top-0" x-show="open" 
                x-transition 
                x-transition:leave="transition ease-in duration-300"
                x-transition:leave-start="opacity-100 scale-100"
                x-transition:leave-end="opacity-0 scale-90"
                >
                    <ul >
                        <li><a href="#" class=" block bg-white p-1 border-l border-solid text-emerald-800 border-gray-500">Web Design</a></li>
                        <li><a href="#" class=" block bg-white p-1 border-l border-solid text-emerald-800 border-gray-500">Hospedagem</a></li>
                        <li><a href="#" class=" block bg-white p-1 border-l border-solid text-emerald-800 border-gray-500">SEO</a></li>
                        <li><a href="#"class=" block bg-white p-1 border-l border-solid text-emerald-800 border-gray-500">Sistemas</a></li>
                    </ul>
                </div>
            </div>
        </li>
    </ul>
