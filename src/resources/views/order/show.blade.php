<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Заказы') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 p-5">
        <h2 class="text-2xl font-bold mb-5">Информация о заказе</h2>
        <dl class="max-w-md text-gray-900 divide-y divide-gray-200 dark:text-white dark:divide-gray-700">
            <div class="flex flex-col pb-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Имя</dt>
                <dd class="text-lg font-semibold">{{ $order->client_name }}</dd>
            </div>
            <div class="flex flex-col py-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Телефон</dt>
                <dd class="text-lg font-semibold">{{ $order->client_phone }}</dd>
            </div>
            <div class="flex flex-col pt-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Тип доставки</dt>
                <dd class="text-lg font-semibold">{{ $order->schedule_type }}</dd>
            </div>
            <div class="flex flex-col pt-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Комментарий</dt>
                <dd class="text-lg font-semibold">{{ $order->comment }}</dd>
            </div>
            <div class="flex flex-col pt-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Начальная дата</dt>
                <dd class="text-lg font-semibold">{{ $order->first_date }}</dd>
            </div>
            <div class="flex flex-col pt-3">
                <dt class="mb-1 text-gray-500 md:text-lg dark:text-gray-400">Конечная дата</dt>
                <dd class="text-lg font-semibold">{{ $order->last_date }}</dd>
            </div>
        </dl>


        <h2 class="text-2xl font-bold mt-14 mb-4">Рационы</h2>
        
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Дата приготовления
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Дата доставки
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($rations as $ration)
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{ $ration->cooking_date }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $ration->delivery_date }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


    </div>
</x-app-layout>