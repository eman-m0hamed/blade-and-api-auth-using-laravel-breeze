<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <form action="/checkout" method="post">
                    @csrf

                    <label for="">select product</label>
                    <select name="products[]" multiple>
                        <option disabled selected>select product</option>
                        @foreach ($products as $product)
                            <option value="{{$product->id}}">{{$product->name}}</option>
                        @endforeach
                    </select>

                    <label for="">amount</label>
                    <input type="number" name="amount">

                    <button>checkout</button>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
