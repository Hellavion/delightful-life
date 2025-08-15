<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';

const activeTab = ref('home');

const tabs = [
  { id: 'home', label: 'Главная', icon: '🏠' },
  { id: 'portfolio', label: 'Портфолио', icon: '💼' },
  { id: 'about', label: 'О себе', icon: '👤' }
];
</script>

<template>
  <Head title="Delightful Life">
    <link rel="preconnect" href="https://rsms.me/" />
    <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
  </Head>

  <div class="min-h-screen bg-gradient-to-br from-indigo-50 via-purple-50 to-pink-50 dark:from-gray-900 dark:via-purple-900 dark:to-indigo-900">
    <!-- Animated Background -->
    <div class="absolute inset-0 overflow-hidden">
      <div class="absolute -top-40 -right-40 w-80 h-80 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
      <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
      <div class="absolute top-40 left-40 w-80 h-80 bg-pink-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
    </div>

    <!-- Header with Logo Placeholder -->
    <header class="relative z-10 pt-8 pb-6">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center items-center">
          <!-- Logo Placeholder -->
          <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg">
            <span class="text-2xl font-bold text-white">DL</span>
          </div>
          <h1 class="ml-4 text-3xl font-bold text-gray-900 dark:text-white">
            Delightful Life
          </h1>
        </div>
      </div>
    </header>

    <!-- Navigation Tabs -->
    <nav class="relative z-10 mb-8">
      <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-center">
          <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-2xl p-2 shadow-xl border border-white/20 dark:border-gray-700/20">
            <div class="flex space-x-2">
              <button
                v-for="tab in tabs"
                :key="tab.id"
                @click="activeTab = tab.id"
                :class="[
                  'flex items-center space-x-2 px-6 py-3 rounded-xl font-medium transition-all duration-300',
                  activeTab === tab.id
                    ? 'bg-gradient-to-r from-purple-500 to-pink-500 text-white shadow-lg transform scale-105'
                    : 'text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white hover:bg-white/50 dark:hover:bg-gray-700/50'
                ]"
              >
                <span class="text-lg">{{ tab.icon }}</span>
                <span>{{ tab.label }}</span>
              </button>
            </div>
          </div>
        </div>
      </div>
    </nav>

    <!-- Content Area -->
    <main class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
      <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-sm rounded-3xl shadow-2xl border border-white/20 dark:border-gray-700/20 overflow-hidden">
        
        <!-- Home Tab -->
        <div v-if="activeTab === 'home'" class="p-8 lg:p-12">
          <div class="text-center mb-12">
            <h2 class="text-4xl lg:text-6xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-6">
              Добро пожаловать в Delightful Life
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto leading-relaxed">
              Создаем прекрасные цифровые решения, которые делают жизнь лучше. 
              От веб-приложений до мобильных решений - мы воплощаем ваши идеи в реальность.
            </p>
          </div>

          <div class="grid md:grid-cols-3 gap-8 mt-16">
            <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20">
              <div class="w-16 h-16 bg-gradient-to-r from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <span class="text-2xl">🎨</span>
              </div>
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Креативный дизайн</h3>
              <p class="text-gray-600 dark:text-gray-300">Создаем уникальные и привлекательные интерфейсы</p>
            </div>

            <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
              <div class="w-16 h-16 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <span class="text-2xl">⚡</span>
              </div>
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Современные технологии</h3>
              <p class="text-gray-600 dark:text-gray-300">Используем последние технологии для лучших результатов</p>
            </div>

            <div class="text-center p-6 rounded-2xl bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20">
              <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-500 rounded-2xl flex items-center justify-center mx-auto mb-4">
                <span class="text-2xl">🚀</span>
              </div>
              <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Быстрая разработка</h3>
              <p class="text-gray-600 dark:text-gray-300">Эффективно доставляем проекты в срок</p>
            </div>
          </div>
        </div>

        <!-- Portfolio Tab -->
        <div v-if="activeTab === 'portfolio'" class="p-8 lg:p-12">
          <div class="text-center mb-12">
            <h2 class="text-4xl lg:text-6xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-6">
              Наши проекты
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
              Посмотрите на наши лучшие работы и убедитесь в качестве наших решений
            </p>
          </div>

          <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-purple-100 to-pink-100 dark:from-purple-900/20 dark:to-pink-900/20">
              <div class="aspect-video bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center">
                <span class="text-4xl">📱</span>
              </div>
              <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Мобильное приложение</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">Современное приложение для управления задачами</p>
                <div class="flex flex-wrap gap-2">
                  <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-sm">React Native</span>
                  <span class="px-3 py-1 bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-300 rounded-full text-sm">Node.js</span>
                </div>
              </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-blue-100 to-cyan-100 dark:from-blue-900/20 dark:to-cyan-900/20">
              <div class="aspect-video bg-gradient-to-br from-blue-400 to-cyan-400 flex items-center justify-center">
                <span class="text-4xl">💻</span>
              </div>
              <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Веб-платформа</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">E-commerce платформа с современным дизайном</p>
                <div class="flex flex-wrap gap-2">
                  <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm">Vue.js</span>
                  <span class="px-3 py-1 bg-cyan-100 dark:bg-cyan-900/30 text-cyan-700 dark:text-cyan-300 rounded-full text-sm">Laravel</span>
                </div>
              </div>
            </div>

            <div class="group relative overflow-hidden rounded-2xl bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900/20 dark:to-emerald-900/20">
              <div class="aspect-video bg-gradient-to-br from-green-400 to-emerald-400 flex items-center justify-center">
                <span class="text-4xl">🎯</span>
              </div>
              <div class="p-6">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Аналитическая система</h3>
                <p class="text-gray-600 dark:text-gray-300 mb-4">Система аналитики с интерактивными дашбордами</p>
                <div class="flex flex-wrap gap-2">
                  <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full text-sm">React</span>
                  <span class="px-3 py-1 bg-emerald-100 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-300 rounded-full text-sm">Python</span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- About Tab -->
        <div v-if="activeTab === 'about'" class="p-8 lg:p-12">
          <div class="text-center mb-12">
            <h2 class="text-4xl lg:text-6xl font-bold bg-gradient-to-r from-purple-600 to-pink-600 bg-clip-text text-transparent mb-6">
              О нас
            </h2>
            <p class="text-xl text-gray-600 dark:text-gray-300 max-w-3xl mx-auto">
              Узнайте больше о нашей команде и подходе к разработке
            </p>
          </div>

          <div class="grid lg:grid-cols-2 gap-12 items-center">
            <div>
              <h3 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">
                Наша миссия
              </h3>
              <p class="text-lg text-gray-600 dark:text-gray-300 mb-6 leading-relaxed">
                Мы создаем цифровые решения, которые не только решают технические задачи, 
                но и приносят радость пользователям. Каждый проект для нас - это возможность 
                сделать мир немного лучше.
              </p>
              <p class="text-lg text-gray-600 dark:text-gray-300 mb-8 leading-relaxed">
                Наша команда объединяет опытных разработчиков, дизайнеров и менеджеров проектов, 
                которые работают вместе для достижения выдающихся результатов.
              </p>

              <div class="grid grid-cols-2 gap-6">
                <div class="text-center">
                  <div class="text-3xl font-bold text-purple-600 dark:text-purple-400">50+</div>
                  <div class="text-gray-600 dark:text-gray-300">Завершенных проектов</div>
                </div>
                <div class="text-center">
                  <div class="text-3xl font-bold text-pink-600 dark:text-pink-400">5+</div>
                  <div class="text-gray-600 dark:text-gray-300">Лет опыта</div>
                </div>
              </div>
            </div>

            <div class="space-y-6">
              <div class="p-6 rounded-2xl bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Наши ценности</h4>
                <ul class="space-y-2 text-gray-600 dark:text-gray-300">
                  <li class="flex items-center">
                    <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>
                    Качество превыше всего
                  </li>
                  <li class="flex items-center">
                    <span class="w-2 h-2 bg-pink-500 rounded-full mr-3"></span>
                    Инновации в каждой детали
                  </li>
                  <li class="flex items-center">
                    <span class="w-2 h-2 bg-purple-500 rounded-full mr-3"></span>
                    Клиент всегда прав
                  </li>
                  <li class="flex items-center">
                    <span class="w-2 h-2 bg-pink-500 rounded-full mr-3"></span>
                    Постоянное развитие
                  </li>
                </ul>
              </div>

              <div class="p-6 rounded-2xl bg-gradient-to-br from-blue-50 to-cyan-50 dark:from-blue-900/20 dark:to-cyan-900/20">
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-3">Технологии</h4>
                <div class="flex flex-wrap gap-2">
                  <span class="px-3 py-1 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 rounded-full text-sm">Vue.js</span>
                  <span class="px-3 py-1 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 rounded-full text-sm">Laravel</span>
                  <span class="px-3 py-1 bg-pink-100 dark:bg-pink-900/30 text-pink-700 dark:text-pink-300 rounded-full text-sm">React</span>
                  <span class="px-3 py-1 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300 rounded-full text-sm">Node.js</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
@keyframes blob {
  0% {
    transform: translate(0px, 0px) scale(1);
  }
  33% {
    transform: translate(30px, -50px) scale(1.1);
  }
  66% {
    transform: translate(-20px, 20px) scale(0.9);
  }
  100% {
    transform: translate(0px, 0px) scale(1);
  }
}

.animate-blob {
  animation: blob 7s infinite;
}

.animation-delay-2000 {
  animation-delay: 2s;
}

.animation-delay-4000 {
  animation-delay: 4s;
}
</style>
