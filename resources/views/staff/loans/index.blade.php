<x-layouts.app :title="__('借出中清單')">
    <div class="p-6 space-y-4">
        <h1 class="text-2xl font-bold">借出中清單（館員）</h1>

        <div class="overflow-x-auto">
            <table class="w-full border">
                <thead>
                    <tr class="border-b">
                        <th class="p-2 text-left">讀者</th>
                        <th class="p-2 text-left">條碼</th>
                        <th class="p-2 text-left">書名</th>
                        <th class="p-2 text-left">借出日</th>
                        <th class="p-2 text-left">到期日</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($loans as $loan)
                        <tr class="border-b">
                            <td class="p-2">{{ $loan->user->email }}</td>
                            <td class="p-2">{{ $loan->copy->barcode }}</td>
                            <td class="p-2">{{ $loan->copy->title?->title ?? '（未知書名）' }}</td>
                            <td class="p-2">{{ $loan->loan_date }}</td>
                            <td class="p-2">{{ $loan->due_date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="p-2" colspan="5">目前沒有借出中的紀錄。</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="text-sm opacity-80">
            快捷：<a class="underline" href="{{ route('staff.loans.return.form') }}">前往歸還</a>
        </div>
    </div>
</x-layouts.app>
