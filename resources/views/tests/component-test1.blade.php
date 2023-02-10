<x-tests.app>
    <x-slot name="header">ヘッダー１</x-slot>
コンポーネントテスト１

    <x-tests.card title="タイトル１" content="本文１" :message="$message" />
    <x-tests.card title="タイトル２" />
    <x-tests.card title="CSSを変更したい" class="bg-red-300" />
</x-tests.app>