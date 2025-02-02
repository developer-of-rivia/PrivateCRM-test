<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Заказы') }}
        </h2>
    </x-slot>

    <div class="relative overflow-x-auto py-12">

        <form method="post" action="{{ route('orders.store') }}" class="max-w-md mx-auto">
            @csrf

            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    ФИО клиента
                </label>
                <input name="name" type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="ФИО" required />
            </div>
            <div class="mb-5">
                <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Номер телефона
                </label>
                <input name="phone" type="text" id="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Телефон" required />
                @if($errors->first('phone'))
                    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                        <span class="font-medium">
                            {{ $errors->first('phone') }}
                        </span>
                    </div>
                @endif
            </div>
            <div class="mb-5">
                <label for="tariff" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Выберите тариф</label>
                <select name="tariff" id="tariff" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @foreach($tariffs as $tariff)
                        <option value="{{ $tariff->id }}">{{ $tariff->ration_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-5">
                <label for="schedule_type" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Выберите тип расписания доставки</label>
                <select name="schedule_type" id="schedule_type" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="EVERY_DAY">Каждый день</option>
                    <option value="EVERY_OTHER_DAY">Через день</option>
                    <option value="EVERY_OTHER_DAY_TWICE">Через день два раза</option>
                </select>
            </div>
            <div class="mb-5">
                <label for="comment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Комментарий</label>
                <textarea name="comment" id="comment" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Комментарий..."></textarea>
            </div>
            <div class="mb-5">
                <label for="first_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Первая дата доставки
                </label>
                <input type="date" id="first_date" name="firstDate" value="2025-01-01">
            </div>
            <div class="mb-5">
                <label for="last_date" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Последняя дата доставки
                </label>
                <input type="date" id="last_date" name="lastDate" value="2025-01-05">
            </div>

            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                Создать
            </button>
        </form>
    </div>
</x-app-layout>
