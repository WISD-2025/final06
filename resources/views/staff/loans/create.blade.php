<x-layouts.app :title="__('館員借出')">
    <div class="p-6 space-y-4">
        <h1 class="text-2xl font-bold">館員借出</h1>

        @if (session('success'))
            <div class="rounded border p-3">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded border p-3">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('staff.loans.store') }}" class="space-y-3">
            @csrf

            <div>
                <label class="block font-semibold">讀者 Email</label>
                <input name="member_email" value="{{ old('member_email') }}"
                        class="border rounded p-2 w-full"
                        placeholder="member@example.com" required>
            </div>

            <div>
                <label class="block font-semibold">館藏條碼</label>
                <input name="barcode" value="{{ old('barcode') }}"
                        class="border rounded p-2 w-full"
                        placeholder="BC0002" required>
            </div>

            <div>
                <label class="block font-semibold">借閱天數（預設 14 天）</label>
                <input name="days" value="{{ old('days', 14) }}"
                        type="number" min="1" max="60"
                        class="border rounded p-2 w-full">
            </div>

            <button class="border rounded px-4 py-2">
                確認借出
            </button>
        </form>
    </div>
</x-layouts.app>
