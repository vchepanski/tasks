@props(['users' => [], 'selectedUsers' => []])
<div x-data="{ open: false, selectedUsers: @json($selectedUsers) }" class="relative mb-6">
    <label class="block text-sm font-medium">Vincular Usuários</label>

    <!-- Botão Dropdown -->
    <div class="p-2 bg-white border rounded cursor-pointer" @click="open = !open">
        <span x-text="selectedUsers.length > 0 ? selectedUsers.length + ' usuários selecionados' : 'Selecione os usuários'"></span>
    </div>

    <!-- Dropdown de usuários -->
    <div x-show="open" class="absolute z-10 w-full mt-2 bg-white border rounded shadow-lg">
        <ul class="p-2 overflow-y-auto max-h-48">
            @foreach($users as $user)
                <li class="flex items-center p-2 space-x-2 hover:bg-gray-100">
                    <input type="checkbox" name="users[]" value="{{ $user->id }}"
                        x-model="selectedUsers"
                        class="w-4 h-4 text-blue-600 form-checkbox">
                    <label class="text-sm">{{ $user->name }}</label>
                </li>
            @endforeach
        </ul>
    </div>
</div>
