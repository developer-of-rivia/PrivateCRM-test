<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Заказы') }}
        </h2>
    </x-slot>

    <div class="relative overflow-x-auto">

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
                <a href="{{ route('orders.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    Создать заказ
                </a>
            </div>
        </div>

        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        ФИО клиента
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Телефон
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Тарифы
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Тип расписания
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Комментарий
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Дата создания заказа
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Начальная дата заказа
                    </th>
                    <th scope="col" class="px-6 py-3">
                        Конечная дата заказа
                    </th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            <a href="{{ route('orders.show', $order->id) }}" class="p-2">
                                {{ $order->id }}
                            </a>
                        </th>
                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                            {{ $order->client_name }}
                        </th>
                        <td class="px-6 py-4">
                            {{ $order->client_phone }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->tariff_id }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->schedule_type }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->comment }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->created_at }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->first_date }}
                        </td>
                        <td class="px-6 py-4">
                            {{ $order->last_date }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-app-layout>
