<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter } from 'vue-router'
import api from '../api'
import profileImage from '../assets/configurator/electric-track-profile.png'
import dimensionsImage from '../assets/configurator/electric-track-dimensions.png'
import materialsImage from '../assets/configurator/electric-track-materials.png'
import automationImage from '../assets/configurator/electric-track-automation.png'

const router = useRouter()

const currentStep = ref(1)
const profiles = ref([])
const materials = ref([])
const automationOptions = ref([])
const loading = ref(true)

const config = ref({
  profile_id: null,
  dimensions: { width: 3000, height: 2500 },
  material_id: null,
  automation: {}
})

const saveState = ref('')

const selectedProfile = computed(() => profiles.value.find(profile => profile.id === config.value.profile_id))
const selectedMaterial = computed(() => materials.value.find(material => material.id === config.value.material_id))
const enabledAutomation = computed(() => automationOptions.value.filter(option => config.value.automation[option.id]))
const area = computed(() => ((config.value.dimensions.width * config.value.dimensions.height) / 1000000).toFixed(2))
const systemReadiness = computed(() => {
  const ready = [
    Boolean(selectedProfile.value),
    currentStep.value >= 2 && Boolean(config.value.dimensions.width && config.value.dimensions.height),
    currentStep.value >= 3 && Boolean(selectedMaterial.value),
    currentStep.value >= 4 && enabledAutomation.value.length > 0
  ].filter(Boolean).length

  return Math.round((ready / 4) * 100)
})

const saveConfiguration = async () => {
  const automationPayload = automationOptions.value.map(o => ({
    id: o.id,
    is_enabled: config.value.automation[o.id] || false
  }))

  saveState.value = 'saving'

  try {
    const { data } = await api.post('/configurations', {
      profile_id: config.value.profile_id,
      width_mm: config.value.dimensions.width,
      height_mm: config.value.dimensions.height,
      material_id: config.value.material_id,
      automation_options: automationPayload
    })
    saveState.value = 'saved'
    window.setTimeout(() => {
      if (saveState.value === 'saved') saveState.value = ''
    }, 2200)
    return data.id
  } catch (e) {
    console.error('Failed to save configuration', e)
    saveState.value = 'error'
    return null
  }
}

const nextStep = () => {
  if (currentStep.value < 4) currentStep.value++
}

const prevStep = () => {
  if (currentStep.value > 1) currentStep.value--
  else router.push('/')
}

const goToCheckout = async () => {
  const configId = await saveConfiguration()
  if (configId) {
    router.push({ path: '/checkout', query: { configuration_id: configId } })
  }
}

onMounted(async () => {
  try {
    const [profilesRes, materialsRes, automationRes] = await Promise.all([
      api.get('/profiles'),
      api.get('/materials'),
      api.get('/automation-options')
    ])
    profiles.value = profilesRes.data
    materials.value = materialsRes.data
    automationOptions.value = automationRes.data

    if (profiles.value.length) config.value.profile_id = profiles.value[0].id
    if (materials.value.length) config.value.material_id = materials.value[0].id
    automationOptions.value.forEach(o => {
      config.value.automation[o.id] = o.slug === 'smartphone-wifi' || o.slug === 'led-perimeter'
    })
  } catch (e) {
    console.error('Failed to load configurator data', e)
  } finally {
    loading.value = false
  }
})
</script>

<template>
  <div class="config-view bg-background text-on-background min-h-screen selection:bg-primary selection:text-on-primary overflow-hidden">
    <nav class="fixed top-0 w-full z-50 rounded-none bg-stone-900/60 backdrop-blur-xl dark:bg-stone-950/60 transition-all duration-300">
      <div class="flex justify-between items-center px-6 md:px-12 py-8 w-full max-w-[100vw] mx-auto">
        <div class="text-xl font-bold tracking-[0.2em] uppercase text-[#cac6be]"><a href="/">Умные системы солнцезащиты</a></div>
        <div class="hidden md:flex items-center gap-10">
          <a class="text-[#cac6be] border-b border-[#cac6be] pb-1 font-['Manrope'] text-sm uppercase tracking-widest transition-colors duration-500" href="#">Профиль</a>
          <a class="text-[#9b9ea7] font-['Manrope'] text-sm uppercase tracking-widest hover:text-[#cac6be] transition-colors duration-500" href="#">Размеры</a>
          <a class="text-[#9b9ea7] font-['Manrope'] text-sm uppercase tracking-widest hover:text-[#cac6be] transition-colors duration-500" href="#">Материалы</a>
          <a class="text-[#9b9ea7] font-['Manrope'] text-sm uppercase tracking-widest hover:text-[#cac6be] transition-colors duration-500" href="#">Автоматика</a>
        </div>
        <div class="flex items-center gap-6">
          <span class="material-symbols-outlined text-[#9b9ea7] cursor-pointer hover:text-[#cac6be] transition-all p-2 duration-500">settings</span>
          <button @click="saveConfiguration" :disabled="currentStep < 4 || saveState === 'saving'" class="bg-primary text-on-primary px-8 py-3 text-sm font-bold uppercase tracking-widest hover:bg-primary-dim transition-all duration-300 disabled:opacity-40 disabled:cursor-not-allowed">
            <span v-if="currentStep < 4">Заполните этапы</span>
            <span v-else-if="saveState === 'saving'">Сохранение...</span>
            <span v-else-if="saveState === 'saved'">Проект сохранен</span>
            <span v-else>Сохранить Проект</span>
          </button>
        </div>
      </div>
    </nav>

    <main class="h-screen flex flex-col pt-24 relative z-0 box-border">
      <div class="w-full px-12 py-8 flex justify-between items-center border-b border-outline-variant/15 relative z-30 bg-background">
        <div class="flex items-center gap-12 w-full max-w-[100vw] mx-auto text-sm">
          <div class="flex items-center gap-4 cursor-pointer hover:opacity-70 transition-opacity" @click="currentStep = 1">
            <span :class="['text-[10px] font-bold tracking-[0.3em] uppercase transition-colors duration-500', currentStep >= 1 ? 'text-primary' : 'text-secondary']">01</span>
            <span :class="['text-[10px] font-bold tracking-[0.3em] uppercase transition-colors duration-500', currentStep >= 1 ? 'text-primary' : 'text-secondary']">Профиль</span>
          </div>
          <div class="h-[1px] flex-grow bg-outline-variant/20 relative overflow-hidden">
            <div class="absolute h-full bg-primary transition-all duration-1000 ease-[cubic-bezier(0.83,0,0.17,1)]" :style="`width: ${(currentStep / 4) * 100}%`"></div>
          </div>
          <div class="flex gap-12">
            <span @click="currentStep = 2" :class="['cursor-pointer hover:opacity-70 text-[10px] font-medium tracking-[0.3em] uppercase transition-colors duration-500', currentStep >= 2 ? 'text-primary' : 'text-secondary']">Размеры</span>
            <span @click="currentStep = 3" :class="['cursor-pointer hover:opacity-70 text-[10px] font-medium tracking-[0.3em] uppercase transition-colors duration-500', currentStep >= 3 ? 'text-primary' : 'text-secondary']">Материалы</span>
            <span @click="currentStep = 4" :class="['cursor-pointer hover:opacity-70 text-[10px] font-medium tracking-[0.3em] uppercase transition-colors duration-500', currentStep >= 4 ? 'text-primary' : 'text-secondary']">Автоматика</span>
          </div>
        </div>
      </div>

      <div class="relative flex-1 overflow-hidden bg-background border-t border-transparent z-10 w-full h-full">
        <div class="absolute top-0 bottom-0 w-3/5 bg-surface-container-low overflow-hidden transition-all duration-1000 ease-[cubic-bezier(0.83,0,0.17,1)] z-10"
             :class="currentStep % 2 !== 0 ? 'left-0' : 'left-[40%]'">
          <Transition name="fade" mode="out-in">
             <img v-if="currentStep === 1" class="w-full h-full object-cover grayscale-[0.2] contrast-[1.1] opacity-90" :src="profileImage" alt="Профиль электрокарниза" key="img1"/>
             <img v-else-if="currentStep === 2" class="w-full h-full object-cover grayscale-[0.35] contrast-[1.1] opacity-90" :src="dimensionsImage" alt="Размеры электрокарниза" key="img2"/>
             <img v-else-if="currentStep === 3" class="w-full h-full object-cover grayscale-[0.1] contrast-[1.1] opacity-90" :src="materialsImage" alt="Материалы электрокарниза" key="img3"/>
             <img v-else class="w-full h-full object-cover grayscale-[0.25] contrast-[1.1] opacity-90" :src="automationImage" alt="Автоматика электрокарниза" key="img4"/>
          </Transition>

          <div class="absolute inset-0 bg-gradient-to-r from-background/90 via-background/40 to-transparent z-10 transition-transform duration-1000 ease-[cubic-bezier(0.83,0,0.17,1)]"
               :class="currentStep % 2 !== 0 ? 'scale-x-100' : 'scale-x-[-1]'"></div>

          <div class="absolute bottom-16 max-w-sm flex flex-col justify-center z-20 transition-all duration-1000 ease-[cubic-bezier(0.83,0,0.17,1)]"
               :class="currentStep % 2 !== 0 ? 'border-l-2 border-primary pl-8 left-24 text-left' : 'border-r-2 border-primary pr-8 right-24 text-right'">
            <Transition name="fade-slide-up" mode="out-in">
                <p :key="`number-${currentStep}`" class="absolute top-1/2 -translate-y-1/2 text-[4.5rem] leading-none noto-serif text-white opacity-40 select-none"
                   :class="currentStep % 2 !== 0 ? '-left-20' : '-right-20'">0{{ currentStep }}</p>
            </Transition>
            <Transition name="fade-slide-up" mode="out-in">
                <div :key="`callout-${currentStep}`">
                    <h3 class="font-headline text-2xl text-white mb-2">
                        <span v-if="currentStep === 1">Техническая Точность</span>
                        <span v-else-if="currentStep === 2">Идеальные Пропорции</span>
                        <span v-else-if="currentStep === 3">Тактильное Совершенство</span>
                        <span v-else>Умная Среда</span>
                    </h3>
                    <p class="font-body text-sm text-white/80 leading-relaxed">
                        <span v-if="currentStep === 1">Наши профили обеспечивают лучшую светопропускаемость без ущерба для прочности конструкции.</span>
                        <span v-else-if="currentStep === 2">Каждый объект производится индивидуально, с точностью до миллиметра под вашу архитектуру.</span>
                        <span v-else-if="currentStep === 3">Анодирование и порошковая покраска высшего класса для защиты от любых климатических условий.</span>
                        <span v-else>Интеграция с Loxone, Somfy и KNX. Создайте полностью автономную биоклиматическую систему.</span>
                    </p>
                </div>
            </Transition>
          </div>
        </div>

        <div class="absolute top-0 bottom-0 w-2/5 p-8 lg:p-12 flex flex-col justify-between bg-surface overflow-y-auto no-scrollbar transition-all duration-1000 ease-[cubic-bezier(0.83,0,0.17,1)] z-20"
             :class="currentStep % 2 !== 0 ? 'left-[60%]' : 'left-0'">
          <section class="pt-8">
            <Transition name="fade-slide-up" mode="out-in">
              <header class="mb-12 shrink-0" :key="`header-${currentStep}`">
                <span class="inline-block py-1 border-b border-primary text-primary text-xs uppercase tracking-[0.3em] mb-6">Этап 0{{ currentStep }}</span>
                <h1 v-if="currentStep === 1" class="font-headline text-4xl md:text-5xl leading-[1.1] text-on-background tracking-tight mb-6">Architectural<br/><span class="italic text-primary-dim">Профиль.</span></h1>
                <h1 v-else-if="currentStep === 2" class="font-headline text-4xl md:text-5xl leading-[1.1] text-on-background tracking-tight mb-6">Точные<br/><span class="italic text-primary-dim">Размеры.</span></h1>
                <h1 v-else-if="currentStep === 3" class="font-headline text-4xl md:text-5xl leading-[1.1] text-on-background tracking-tight mb-6">Premium<br/><span class="italic text-primary-dim">Покрытие.</span></h1>
                <h1 v-else-if="currentStep === 4" class="font-headline text-4xl md:text-5xl leading-[1.1] text-on-background tracking-tight mb-6">Smart Home<br/><span class="italic text-primary-dim">Среда.</span></h1>
                <p class="text-secondary font-body max-w-md leading-relaxed text-base">
                  <span v-if="currentStep === 1">Выберите основной несущий каркас для вашего проекта. Каждый профиль изготовлен из авиационного алюминия с высокой точностью.</span>
                  <span v-else-if="currentStep === 2">Укажите ширину и высоту проема. Наши системы поддерживают огромные безопорные пролеты до 8 метров.</span>
                  <span v-else-if="currentStep === 3">Подберите текстуру и цвет, чтобы они идеально гармонировали с фасадом вашего здания.</span>
                  <span v-else-if="currentStep === 4">Добавьте датчики и модули для автоматического закрытия при ветре и дожде или настройте LED-подсветку.</span>
                </p>
              </header>
            </Transition>

            <div class="min-h-[300px]">
              <div v-if="loading" class="text-center py-20 text-secondary">Загрузка...</div>
              <template v-else>
                <Transition name="fade-slide-up" mode="out-in">
                  <div v-if="currentStep === 1" class="space-y-4" key="step1">
                    <div v-for="profile in profiles" :key="profile.id"
                         @click="config.profile_id = profile.id"
                         :class="['group cursor-pointer p-6 transition-all duration-500 border-l-2', config.profile_id === profile.id ? 'bg-surface-container-high border-primary' : 'bg-surface-container-low hover:bg-surface-container-high border-transparent hover:border-outline-variant/30']">
                      <div class="flex justify-between items-start mb-3">
                        <h4 :class="['font-headline text-xl transition-colors duration-500', config.profile_id === profile.id ? 'text-primary' : 'text-on-surface group-hover:text-primary']">{{ profile.name }}</h4>
                        <span :class="['material-symbols-outlined transition-colors duration-500', config.profile_id === profile.id ? 'text-primary' : 'text-outline-variant group-hover:text-primary']" :style="config.profile_id === profile.id ? `font-variation-settings: 'FILL' 1;` : ''">{{ config.profile_id === profile.id ? 'check_circle' : 'radio_button_unchecked' }}</span>
                      </div>
                      <p class="text-xs text-secondary leading-relaxed mb-4">{{ profile.description }}</p>
                      <div v-if="profile.tags && profile.tags.length" class="flex gap-3 flex-wrap">
                        <span v-for="tag in profile.tags" :key="tag" class="text-[10px] tracking-[0.2em] uppercase px-2 py-1 bg-surface-container text-secondary border border-outline-variant/30">{{ tag }}</span>
                      </div>
                    </div>
                  </div>

                  <div v-else-if="currentStep === 2" class="space-y-12" key="step2">
                    <div>
                      <div class="flex justify-between items-end mb-4">
                        <span class="text-secondary font-bold uppercase tracking-widest text-xs">Ширина проема</span>
                        <span class="text-primary font-headline text-3xl">{{ config.dimensions.width }}<span class="text-secondary text-sm ml-1 uppercase border-b border-primary/30">мм</span></span>
                      </div>
                      <input type="range" min="1000" max="8000" step="10" v-model="config.dimensions.width" class="w-full h-1 bg-surface-container-highest appearance-none cursor-pointer outline-none transition-all duration-300 ring-primary">
                      <div class="flex justify-between text-[#9b9ea7] text-[10px] uppercase font-bold tracking-widest mt-3">
                        <span>1000 мм</span>
                        <span>8000 мм</span>
                      </div>
                    </div>
                    <div>
                      <div class="flex justify-between items-end mb-4">
                        <span class="text-secondary font-bold uppercase tracking-widest text-xs">Высота проема</span>
                        <span class="text-primary font-headline text-3xl">{{ config.dimensions.height }}<span class="text-secondary text-sm ml-1 uppercase border-b border-primary/30">мм</span></span>
                      </div>
                      <input type="range" min="1500" max="3500" step="10" v-model="config.dimensions.height" class="w-full h-1 bg-surface-container-highest appearance-none cursor-pointer outline-none transition-all duration-300">
                      <div class="flex justify-between text-[#9b9ea7] text-[10px] uppercase font-bold tracking-widest mt-3">
                        <span>1500 мм</span>
                        <span>3500 мм</span>
                      </div>
                    </div>
                  </div>

                  <div v-else-if="currentStep === 3" class="grid grid-cols-2 lg:grid-cols-3 gap-6" key="step3">
                    <div v-for="material in materials" :key="material.id"
                         @click="config.material_id = material.id"
                         :class="['cursor-pointer group flex flex-col items-center gap-4 transition-all duration-500', config.material_id === material.id ? 'opacity-100 scale-105' : 'opacity-40 hover:opacity-100 scale-95 hover:scale-100']">
                      <div class="w-20 h-20 rounded-full shadow-inner border border-white/10 flex items-center justify-center relative ring-offset-[#0e0e0e] ring-offset-4 ring-2 transition-all duration-500"
                           :class="config.material_id === material.id ? 'ring-primary' : 'ring-transparent'"
                           :style="`background-color: ${material.hex_color}`">
                        <span v-if="config.material_id === material.id" class="material-symbols-outlined text-white text-lg" style="font-variation-settings: 'FILL' 1;">check</span>
                      </div>
                      <span class="text-[10px] uppercase font-bold tracking-[0.2em] text-secondary text-center leading-relaxed">{{ material.name }}</span>
                    </div>
                  </div>

                  <div v-else-if="currentStep === 4" class="space-y-4" key="step4">
                    <div v-for="option in automationOptions" :key="option.id"
                         @click="config.automation[option.id] = !config.automation[option.id]"
                         :class="['cursor-pointer p-6 border-l-2 transition-all duration-500 flex justify-between items-center', config.automation[option.id] ? 'bg-surface-container-high border-primary' : 'bg-surface-container-low border-transparent hover:bg-surface-container-high hover:border-outline-variant/30']">
                      <div class="flex gap-6 items-center">
                        <span :class="['material-symbols-outlined text-3xl transition-colors duration-500', config.automation[option.id] ? 'text-primary' : 'text-outline-variant']">{{ option.icon || 'settings' }}</span>
                        <div>
                          <h4 :class="['font-headline text-lg transition-colors duration-500', config.automation[option.id] ? 'text-primary' : 'text-on-surface']">{{ option.name }}</h4>
                          <p class="text-[10px] uppercase tracking-widest text-secondary mt-1">{{ option.subtitle || option.description }}</p>
                        </div>
                      </div>
                      <div :class="['w-10 h-5 rounded-full relative transition-colors duration-500', config.automation[option.id] ? 'bg-primary' : 'bg-surface-container-highest']">
                        <div :class="['w-3 h-3 bg-white rounded-full absolute top-1 transition-all duration-300', config.automation[option.id] ? 'left-6' : 'left-1']"></div>
                      </div>
                    </div>
                  </div>
                </Transition>
              </template>
            </div>

            <aside class="mt-10 border border-outline-variant/15 bg-background/60 p-6">
              <div class="flex items-center justify-between gap-6 mb-5">
                <div>
                  <span class="text-[10px] uppercase tracking-[0.3em] text-primary">Спецификация</span>
                  <h3 class="font-headline text-2xl text-on-background mt-2">Проект солнцезащитной системы</h3>
                </div>
                <div class="text-right">
                  <div class="text-3xl font-headline text-primary">{{ systemReadiness }}%</div>
                  <div class="text-[10px] uppercase tracking-[0.2em] text-secondary">готовность</div>
                </div>
              </div>

              <div class="grid grid-cols-2 gap-px bg-outline-variant/10 text-sm">
                <div class="bg-surface p-4">
                  <div class="text-[10px] uppercase tracking-[0.2em] text-secondary mb-2">Профиль</div>
                  <div class="text-on-surface font-semibold">{{ selectedProfile?.name || 'Не выбран' }}</div>
                </div>
                <div v-if="currentStep >= 2" class="bg-surface p-4">
                  <div class="text-[10px] uppercase tracking-[0.2em] text-secondary mb-2">Площадь</div>
                  <div class="text-on-surface font-semibold">{{ area }} м2</div>
                </div>
                <div v-if="currentStep >= 2" class="bg-surface p-4">
                  <div class="text-[10px] uppercase tracking-[0.2em] text-secondary mb-2">Размер</div>
                  <div class="text-on-surface font-semibold">{{ config.dimensions.width }} x {{ config.dimensions.height }} мм</div>
                </div>
                <div v-if="currentStep >= 3" class="bg-surface p-4">
                  <div class="text-[10px] uppercase tracking-[0.2em] text-secondary mb-2">Покрытие</div>
                  <div class="text-on-surface font-semibold">{{ selectedMaterial?.name || 'Не выбрано' }}</div>
                </div>
                <div v-if="currentStep < 2" class="bg-surface p-4 text-sm text-secondary">
                  Следующий этап откроет размер и площадь.
                </div>
              </div>

              <div v-if="currentStep >= 4" class="mt-5">
                <div class="text-[10px] uppercase tracking-[0.2em] text-secondary mb-3">Автоматика и функции</div>
                <div v-if="enabledAutomation.length" class="flex flex-wrap gap-2">
                  <span v-for="option in enabledAutomation" :key="option.id" class="px-3 py-2 bg-surface-container-high text-primary text-[10px] uppercase tracking-[0.18em] border border-primary/20">
                    {{ option.name }}
                  </span>
                </div>
                <p v-else class="text-sm text-secondary">Опции автоматики пока не выбраны.</p>
              </div>
              <p v-else class="mt-5 text-sm text-secondary">Автоматика появится в спецификации после четвертого этапа.</p>
            </aside>
          </section>

          <div class="mt-8 flex justify-between items-center border-t border-outline-variant/15 pt-8 shrink-0">
            <button @click="prevStep" class="flex items-center gap-2 text-secondary hover:text-primary transition-colors uppercase tracking-[0.2em] text-xs font-bold duration-500">
              <span class="material-symbols-outlined text-sm text-primary">arrow_back</span>
              <span v-if="currentStep === 1">Назад к Главной</span>
              <span v-else>Пред. Этап</span>
            </button>
            <button v-if="currentStep < 4" @click="nextStep" class="bg-primary text-on-primary px-12 py-5 font-bold uppercase tracking-widest text-sm hover:bg-primary-dim transition-all duration-500 flex items-center gap-4">
              Следующий Этап
              <span class="material-symbols-outlined">arrow_forward</span>
            </button>
            <button v-else @click="goToCheckout" class="bg-[#cac6be] text-[#0e0e0e] px-12 py-5 font-bold uppercase tracking-widest text-sm hover:brightness-110 transition-all duration-500 flex items-center gap-4">
              Итог Проекта
              <span class="material-symbols-outlined">check</span>
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>

<style scoped>
.fade-slide-up-enter-active,
.fade-slide-up-leave-active {
  transition: all 0.6s cubic-bezier(0.83, 0, 0.17, 1);
}
.fade-slide-up-enter-from {
  opacity: 0;
  transform: translateY(20px);
}
.fade-slide-up-leave-to {
  opacity: 0;
  transform: translateY(-20px);
}
.fade-enter-active,
.fade-leave-active {
  transition: opacity 1s ease;
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}
input[type=range]::-webkit-slider-thumb {
  -webkit-appearance: none;
  height: 16px;
  width: 16px;
  border-radius: 50%;
  background: var(--color-primary, #ffffff);
  cursor: pointer;
  margin-top: -6px;
}
input[type=range]::-moz-range-thumb {
  height: 16px;
  width: 16px;
  border-radius: 50%;
  background: var(--color-primary, #ffffff);
  cursor: pointer;
}
</style>
