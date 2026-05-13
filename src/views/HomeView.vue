<script setup>
import { ref, onMounted } from 'vue'
import api from '../api'

const categories = ref([])
const loading = ref(true)

onMounted(async () => {
  try {
    const { data } = await api.get('/categories')
    categories.value = data
  } catch (e) {
    console.error('Failed to load categories', e)
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div class="home-view bg-background text-on-background min-h-screen selection:bg-primary selection:text-on-primary">

    <nav class="fixed top-0 w-full z-50 rounded-none bg-stone-900/60 backdrop-blur-xl dark:bg-stone-950/60 transition-all duration-300">
      <div class="flex justify-between items-center px-6 md:px-12 py-8 w-full max-w-screen-2xl mx-auto">
        <div class="text-xl font-bold tracking-[0.2em] uppercase text-[#cac6be]"><a href="/">Умные системы солнцезащиты</a></div>
        <div class="hidden md:flex items-center gap-10">
          <a class="text-[#9b9ea7] font-['Manrope'] text-sm uppercase tracking-widest hover:text-[#cac6be] transition-colors duration-500" href="#">Системы</a>
          <a class="text-[#9b9ea7] font-['Manrope'] text-sm uppercase tracking-widest hover:text-[#cac6be] transition-colors duration-500" href="#">Архитектура</a>
          <a class="text-[#9b9ea7] font-['Manrope'] text-sm uppercase tracking-widest hover:text-[#cac6be] transition-colors duration-500" href="#">Наследие</a>
          <a class="text-[#9b9ea7] font-['Manrope'] text-sm uppercase tracking-widest hover:text-[#cac6be] transition-colors duration-500" href="#">Галерея</a>
          <a class="text-[#9b9ea7] font-['Manrope'] text-sm uppercase tracking-widest hover:text-[#cac6be] transition-colors duration-500" href="#">Контакты</a>
        </div>
        <button class="hidden md:block bg-primary text-on-primary px-8 py-3 text-sm font-bold uppercase tracking-widest hover:bg-primary-dim transition-all duration-300">
          Запросить консультацию
        </button>
        <button class="md:hidden text-primary">
          <span class="material-symbols-outlined">menu</span>
        </button>
      </div>
    </nav>

    <main>
      <section class="relative min-h-screen flex items-center justify-start overflow-hidden">
        <div class="absolute inset-0 z-0">
          <div class="absolute inset-0 bg-gradient-to-r from-background via-background/40 to-transparent z-10"></div>
          <img alt="Luxury bioclimatic pergola" class="w-full h-full object-cover grayscale-[0.2] contrast-[1.1]" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCEDTos_6neqHfZBjUD6zwAmuOHTuJ0c0r0B6u0NCH9DmcHEKYSZDokcvigTpyznyClu_HnVHHSHCbPREdhOrVvJq4vHazPMtx5uN7q8v6QrTjiHfzob-JBBgq3vqSnTfNWECByKa07lTB6KNd6BSwg7hkANsCGqI4Q0mE02N-09uN53xIlzZbJhaipG2Qa3amrY_Xtqo3GdbAhrBEDvhKu3lslqSv9rlU5RbNcoBrvFaJoZYmMcnXImdHSl53cVKUQqVEwSrl0_w"/>
        </div>
        <div class="relative z-20 w-full max-w-screen-2xl mx-auto px-6 md:px-12 pt-32">
          <div class="max-w-3xl">
            <span class="inline-block py-1 border-b border-primary text-primary text-xs uppercase tracking-[0.3em] mb-8">Системы 2026</span>
            <h1 class="font-headline text-5xl md:text-[5.5rem] leading-[1.1] text-on-background tracking-tight mb-12">
              Информационная система <br/>
              <span class="italic text-primary-dim">подбора солнцезащиты.</span>
            </h1>
            <p class="font-body text-lg md:text-xl text-secondary max-w-xl mb-16 leading-relaxed">
              Каталог, конфигуратор, техническая спецификация и заявка объединены в один процесс для ООО «Умные системы солнцезащиты».
            </p>
            <div class="flex flex-col sm:flex-row gap-6">
              <button @click="$router.push('/configurator')" class="bg-primary text-on-primary px-12 py-5 font-bold uppercase tracking-widest text-sm hover:bg-primary-dim transition-all duration-500">
                Подобрать решение
              </button>
              <button class="border border-outline-variant/30 text-on-background px-12 py-5 font-bold uppercase tracking-widest text-sm hover:bg-on-surface/5 transition-all duration-500">
                Заказать замер
              </button>
            </div>
          </div>
        </div>
      </section>

      <section class="py-28 px-6 md:px-12 max-w-screen-2xl mx-auto border-b border-outline-variant/15">
        <div class="mb-16 flex flex-col md:flex-row md:items-end justify-between gap-8">
          <div>
            <span class="inline-block py-1 border-b border-primary text-primary text-xs uppercase tracking-[0.3em] mb-6">Логика системы</span>
            <h2 class="font-headline text-4xl md:text-5xl text-on-background mb-4">От выбора решения до заявки</h2>
            <p class="text-secondary max-w-2xl leading-relaxed">Система закрывает полный клиентский сценарий: просмотр ассортимента, подбор технических параметров, фиксация конфигурации и передача заявки менеджеру.</p>
          </div>
          <button @click="$router.push('/configurator')" class="bg-primary text-on-primary px-10 py-4 font-bold uppercase tracking-widest text-xs hover:bg-primary-dim transition-all duration-500">
            Открыть конфигуратор
          </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-px bg-outline-variant/15">
          <div class="bg-background p-8 min-h-[240px] flex flex-col justify-between group">
            <div>
              <span class="material-symbols-outlined text-primary text-4xl mb-8">inventory_2</span>
              <h3 class="font-headline text-2xl text-on-background mb-4">Каталог</h3>
              <p class="text-secondary text-sm leading-relaxed">Категории и продукты солнцезащитных систем загружаются из базы данных и управляются через админ-панель.</p>
            </div>
            <span class="text-[10px] uppercase tracking-[0.3em] text-primary mt-8">01 / данные</span>
          </div>

          <div class="bg-background p-8 min-h-[240px] flex flex-col justify-between group">
            <div>
              <span class="material-symbols-outlined text-primary text-4xl mb-8">tune</span>
              <h3 class="font-headline text-2xl text-on-background mb-4">Конфигуратор</h3>
              <p class="text-secondary text-sm leading-relaxed">Пользователь выбирает профиль, габариты, покрытие и автоматику, формируя индивидуальную спецификацию.</p>
            </div>
            <span class="text-[10px] uppercase tracking-[0.3em] text-primary mt-8">02 / подбор</span>
          </div>

          <div class="bg-background p-8 min-h-[240px] flex flex-col justify-between group">
            <div>
              <span class="material-symbols-outlined text-primary text-4xl mb-8">fact_check</span>
              <h3 class="font-headline text-2xl text-on-background mb-4">Заявка</h3>
              <p class="text-secondary text-sm leading-relaxed">Сохраненная конфигурация передается вместе с контактами клиента, чтобы менеджер видел весь состав проекта.</p>
            </div>
            <span class="text-[10px] uppercase tracking-[0.3em] text-primary mt-8">03 / заказ</span>
          </div>

          <div class="bg-background p-8 min-h-[240px] flex flex-col justify-between group">
            <div>
              <span class="material-symbols-outlined text-primary text-4xl mb-8">admin_panel_settings</span>
              <h3 class="font-headline text-2xl text-on-background mb-4">Админка</h3>
              <p class="text-secondary text-sm leading-relaxed">Сотрудник компании управляет справочниками, просматривает конфигурации и меняет статусы заказов.</p>
            </div>
            <span class="text-[10px] uppercase tracking-[0.3em] text-primary mt-8">04 / обработка</span>
          </div>
        </div>
      </section>

      <section class="py-32 px-6 md:px-12 max-w-screen-2xl mx-auto">
        <div class="mb-24 flex flex-col md:flex-row md:items-end justify-between gap-8">
          <div>
            <h2 class="font-headline text-4xl md:text-5xl text-on-background mb-4">Коллекция</h2>
            <p class="text-secondary max-w-md">Автоматизированные системы, спроектированные для идеальной интеграции в премиальные архитектурные проекты.</p>
          </div>
          <div class="text-secondary text-sm font-label uppercase tracking-widest border-b border-outline-variant/20 pb-2">
            01 // {{ categories.length }} Архитектурных Решений
          </div>
        </div>

        <div v-if="loading" class="text-center py-20 text-secondary">Загрузка...</div>

        <div v-else class="grid grid-cols-1 md:grid-cols-12 gap-1">
          <template v-for="(category, index) in categories" :key="category.id">
            <div v-if="index % 2 === 0" class="md:col-span-8 group relative overflow-hidden bg-surface-container-low">
              <img v-if="category.image" :alt="category.name" class="absolute inset-0 w-full h-full object-cover grayscale transition-transform duration-1000 group-hover:scale-105" :src="category.image" />
              <div v-else class="absolute inset-0 bg-gradient-to-br from-stone-800 to-stone-900"></div>
              <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-12">
                <div class="w-1 h-12 bg-primary mb-6"></div>
                <h3 class="font-headline text-3xl text-white mb-2">{{ category.name }}</h3>
                <p class="text-on-secondary-container max-w-sm">{{ category.description }}</p>
              </div>
              <div v-if="category.system_code" class="absolute top-8 left-8">
                <span class="text-white text-xs tracking-widest uppercase opacity-60">{{ category.system_code }}</span>
              </div>
            </div>
            <div v-else class="md:col-span-4 group relative aspect-square overflow-hidden bg-surface-container-high">
              <img v-if="category.image" :alt="category.name" class="absolute inset-0 w-full h-full object-cover grayscale transition-transform duration-1000 group-hover:scale-105" :src="category.image" />
              <div v-else class="absolute inset-0 bg-gradient-to-br from-stone-700 to-stone-800"></div>
              <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex flex-col justify-end p-8">
                <div class="w-1 h-8 bg-secondary mb-4"></div>
                <h3 class="font-headline text-2xl text-white mb-2">{{ category.name }}</h3>
                <p class="text-on-secondary-container text-sm">{{ category.description }}</p>
              </div>
            </div>
          </template>
        </div>
      </section>

      <section class="bg-surface-container-low py-40">
        <div class="max-w-screen-2xl mx-auto px-6 md:px-12 grid grid-cols-1 md:grid-cols-2 gap-24 items-stretch">
          <div>
            <h2 class="font-headline text-5xl md:text-6xl text-on-background leading-tight mb-12">
              Основы <br/>Современного Комфорта.
            </h2>
            <div class="space-y-12">
              <div class="flex gap-8 group">
                <span class="text-primary font-headline text-2xl opacity-40 group-hover:opacity-100 transition-opacity">01</span>
                <div>
                  <h4 class="text-on-background font-bold uppercase tracking-widest text-sm mb-4">Качество и Материалы</h4>
                  <p class="text-secondary max-w-sm leading-relaxed">Использование лучших алюминиевых сплавов и технического текстиля от европейских производителей.</p>
                </div>
              </div>
              <div class="flex gap-8 group">
                <span class="text-primary font-headline text-2xl opacity-40 group-hover:opacity-100 transition-opacity">02</span>
                <div>
                  <h4 class="text-on-background font-bold uppercase tracking-widest text-sm mb-4">Технологии 2026</h4>
                  <p class="text-secondary max-w-sm leading-relaxed">Интегрированные датчики умного дома и бесшумные моторы для полностью автономной среды.</p>
                </div>
              </div>
              <div class="flex gap-8 group">
                <span class="text-primary font-headline text-2xl opacity-40 group-hover:opacity-100 transition-opacity">03</span>
                <div>
                  <h4 class="text-on-background font-bold uppercase tracking-widest text-sm mb-4">Индивидуальные Решения</h4>
                  <p class="text-secondary max-w-sm leading-relaxed">Каждая установка — это кастомный проект, адаптированный под уникальную геометрию вашего пространства.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="relative bg-surface overflow-hidden h-full min-h-[550px]">
            <img alt="Architectural detail" class="w-full h-full object-cover grayscale opacity-80" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCt4INU1YiGwONBNAV_dl1_LU4RUmcFy4I9fwyfDO6DWh_LKg2wij2vpnHdUUc9gsnZ0MElCFJu2VWMnz95g5uynWxHNwBA-tfGIg0DW42LtpScIFaMtXr0Ip_YCcboSPNQ-HgSXYY024dxzX7hf61AxUyPNS9KircG8Bb-5LFx5N4vfAfcNb756wS_8ruKOeLyf5_spIxWtCLm4dztqwhZYib6A2vOULIbzMZckEv1yqQLqs96xBS_YmIOmsDuFFTAmBt3weEPog"/>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-primary text-on-primary p-10 max-w-sm">
              <span class="material-symbols-outlined text-4xl mb-6">verified</span>
              <p class="font-body text-sm font-semibold uppercase tracking-wider leading-relaxed">
                Сертифицированная надежность для экстремального климата и архитектурная долговечность.
              </p>
            </div>
          </div>
        </div>
      </section>

      <section class="py-40 text-center px-6">
        <div class="max-w-4xl mx-auto">
          <h2 class="font-headline text-4xl md:text-6xl text-on-background mb-12">Готовы преобразить ваше пространство?</h2>
          <p class="text-secondary text-lg mb-16 max-w-2xl mx-auto leading-relaxed">Наши специалисты готовы предоставить подробную техническую консультацию и точные замеры на вашем объекте.</p>
          <div class="flex flex-col md:flex-row justify-center gap-8">
            <a class="inline-flex items-center justify-center gap-4 border-b-2 border-primary pb-2 text-primary font-bold uppercase tracking-widest text-sm hover:text-white hover:border-white transition-all duration-300" href="#">
              Смотреть Портфолио <span class="material-symbols-outlined">arrow_right_alt</span>
            </a>
            <a class="inline-flex items-center justify-center gap-4 border-b-2 border-primary pb-2 text-primary font-bold uppercase tracking-widest text-sm hover:text-white hover:border-white transition-all duration-300" href="#">
              Запросить Расчет <span class="material-symbols-outlined">arrow_right_alt</span>
            </a>
          </div>
        </div>
      </section>
    </main>

    <footer class="bg-[#0e0e0e] dark:bg-[#0e0e0e] rounded-none w-full border-t border-[#474848]/15">
      <div class="flex flex-col md:flex-row justify-between items-start px-12 py-24 w-full max-w-screen-2xl mx-auto">
        <div class="mb-12 md:mb-0">
          <div class="text-lg font-serif italic text-[#cac6be] mb-8">Умные системы солнцезащиты</div>
          <p class="text-[#9b9ea7] font-['Manrope'] text-sm tracking-wide leading-relaxed max-w-xs">
            Переосмысление роскоши через архитектурные солнцезащитные системы и автоматизацию интерьера.
          </p>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-12 w-full md:w-auto">
          <div class="flex flex-col gap-4">
            <span class="text-[#cac6be] text-xs font-bold uppercase tracking-widest mb-2">Компания</span>
            <a class="text-[#9b9ea7] text-sm hover:text-[#e9ffeb] transition-opacity duration-300" href="#">Архитектура</a>
            <a class="text-[#9b9ea7] text-sm hover:text-[#e9ffeb] transition-opacity duration-300" href="#">Наследие</a>
            <a class="text-[#9b9ea7] text-sm hover:text-[#e9ffeb] transition-opacity duration-300" href="#">Проекты</a>
          </div>
          <div class="flex flex-col gap-4">
            <span class="text-[#cac6be] text-xs font-bold uppercase tracking-widest mb-2">Поддержка</span>
            <a class="text-[#9b9ea7] text-sm hover:text-[#e9ffeb] transition-opacity duration-300" href="#">Реквизиты</a>
            <a class="text-[#9b9ea7] text-sm hover:text-[#e9ffeb] transition-opacity duration-300" href="#">Конфиденциальность</a>
          </div>
          <div class="flex flex-col gap-4">
            <span class="text-[#cac6be] text-xs font-bold uppercase tracking-widest mb-2">Связь</span>
            <a class="text-[#9b9ea7] text-sm hover:text-[#e9ffeb] transition-opacity duration-300" href="#">LinkedIn</a>
            <a class="text-[#9b9ea7] text-sm hover:text-[#e9ffeb] transition-opacity duration-300" href="#">Instagram</a>
          </div>
          <div class="flex flex-col gap-4">
            <span class="text-[#cac6be] text-xs font-bold uppercase tracking-widest mb-2">География</span>
            <p class="text-[#9b9ea7] text-sm italic">Мюнхен / Дубай / Лондон</p>
          </div>
        </div>
      </div>
      <div class="px-12 pb-12 w-full max-w-screen-2xl mx-auto flex justify-between items-center text-[#9b9ea7] text-[10px] uppercase tracking-[0.2em]">
        <span>&copy; 2026 ООО «Умные системы солнцезащиты». Архитектурная Точность.</span>
        <span class="hidden md:block">Сайт от Monolith Studio</span>
      </div>
    </footer>

  </div>
</template>
