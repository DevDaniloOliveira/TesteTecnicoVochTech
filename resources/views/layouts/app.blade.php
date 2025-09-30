<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <livewire:layout.navigation />

        <!-- Page Heading -->
        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    <!-- Container de Notificações -->
    <div x-data="notificationHandler()" class="fixed top-4 right-4 z-50 space-y-2">
        <template x-for="(notification, index) in notifications" :key="index">
            <div x-show="notification.visible" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform translate-x-full"
                x-transition:enter-end="opacity-100 transform translate-x-0"
                x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 transform translate-x-0"
                x-transition:leave-end="opacity-0 transform translate-x-full"
                :class="{
                    'bg-green-500': notification.type === 'success',
                    'bg-red-500': notification.type === 'error',
                    'bg-blue-500': notification.type === 'info',
                    'bg-yellow-500': notification.type === 'warning'
                }"
                class="text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-3 min-w-80">
                <!-- Ícone -->
                <span x-text="getIcon(notification.type)" class="text-lg"></span>

                <!-- Mensagem -->
                <span x-text="notification.message" class="flex-1"></span>

                <!-- Botão Fechar -->
                <button @click="removeNotification(index)" class="text-white hover:text-gray-200">
                    &times;
                </button>
            </div>
        </template>
    </div>
</body>
<script>
    function notificationHandler() {
        return {
            notifications: [],

            init() {
                // Escutar eventos do Livewire
                Livewire.on('notify', (data) => {
                    this.addNotification(data.type, data.message);
                });

                // Verificar se há mensagens flash da session
                @if (session()->has('success'))
                    this.addNotification('success', '{{ session('success') }}');
                @endif
                @if (session()->has('error'))
                    this.addNotification('error', '{{ session('error') }}');
                @endif
                @if (session()->has('info'))
                    this.addNotification('info', '{{ session('info') }}');
                @endif
            },

            addNotification(type, message) {
                const notification = {
                    type: type,
                    message: message,
                    visible: true
                };

                this.notifications.push(notification);

                // Auto-remover após 5 segundos
                setTimeout(() => {
                    this.removeNotification(this.notifications.indexOf(notification));
                }, 5000);
            },

            removeNotification(index) {
                if (this.notifications[index]) {
                    this.notifications[index].visible = false;

                    // Remover do array após animação
                    setTimeout(() => {
                        this.notifications.splice(index, 1);
                    }, 200);
                }
            },

            getIcon(type) {
                const icons = {
                    'success': '✅',
                    'error': '❌',
                    'info': 'ℹ️',
                    'warning': '⚠️'
                };
                return icons[type] || 'ℹ️';
            }
        }
    }
</script>

</html>
