<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import api from '../api'

const router = useRouter()
const route = useRoute()

const form = ref({
  name: '',
  phone: ''
})
const isSubmitted = ref(false)
const isSubmitting = ref(false)
const error = ref(null)
const configuration = ref(null)
const isLoadingConfiguration = ref(false)

const configurationId = computed(() => route.query.configuration_id)
const enabledAutomation = computed(() => {
  if (!configuration.value?.automation_options) return []

  return configuration.value.automation_options.filter(option => option.pivot?.is_enabled)
})
const area = computed(() => {
  if (!configuration.value) return '0.00'

  return ((configuration.value.width_mm * configuration.value.height_mm) / 1000000).toFixed(2)
})

onMounted(async () => {
  if (!configurationId.value) return

  isLoadingConfiguration.value = true

  try {
    const { data } = await api.get(`/configurations/${configurationId.value}`)
    configuration.value = data
  } catch (e) {
    console.error('Failed to load configuration', e)
  } finally {
    isLoadingConfiguration.value = false
  }
})

const submitForm = async () => {
  if (!form.value.name || !form.value.phone) return
  isSubmitting.value = true
  error.value = null

  try {
    await api.post('/orders', {
      configuration_id: configurationId.value || null,
      client_name: form.value.name,
      client_phone: form.value.phone
    })
    isSubmitted.value = true
  } catch (e) {
    error.value = e.response?.data?.message || 'Произошла ошибка при отправке заявки'
  } finally {
    isSubmitting.value = false
  }
}
</script>

<template>
  <div class="checkout-view bg-background text-on-background min-h-screen selection:bg-primary selection:text-on-primary font-body overflow-hidden">
    
    <nav class="fixed top-0 w-full z-50 rounded-none bg-transparent transition-all duration-300">
      <div class="flex justify-between items-center px-6 md:px-12 py-8 w-full max-w-[100vw] mx-auto">
        <div class="text-xl font-bold tracking-[0.2em] uppercase text-[#cac6be] cursor-pointer" @click="router.push('/')">Умные системы солнцезащиты</div>
        <div class="flex items-center gap-6">
          <button @click="router.push('/configurator')" class="flex items-center gap-2 text-primary hover:text-white transition-colors uppercase tracking-[0.2em] text-xs font-bold duration-500">
            <span class="material-symbols-outlined text-sm">arrow_back</span>
            ВЕРНУТЬСЯ
          </button>
        </div>
      </div>
    </nav>

    <main class="flex h-screen w-full">
        <div class="w-1/2 relative bg-surface-container-low overflow-hidden hidden lg:block">
            <img class="w-full h-full object-cover grayscale-[0.3] contrast-[1.1] opacity-70" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCt4INU1YiGwONBNAV_dl1_LU4RUmcFy4I9fwyfDO6DWh_LKg2wij2vpnHdUUc9gsnZ0MElCFJu2VWMnz95g5uynWxHNwBA-tfGIg0DW42LtpScIFaMtXr0Ip_YCcboSPNQ-HgSXYY024dxzX7hf61AxUyPNS9KircG8Bb-5LFx5N4vfAfcNb756wS_8ruKOeLyf5_spIxWtCLm4dztqwhZYib6A2vOULIbzMZckEv1yqQLqs96xBS_YmIOmsDuFFTAmBt3weEPog" alt="Architectural Project Completion" />
            <div class="absolute inset-0 bg-gradient-to-t from-background/90 to-transparent"></div>
            
            <div class="absolute bottom-24 left-16 max-w-lg border-l-2 border-primary pl-10 flex flex-col justify-center">
                <h3 class="font-headline text-5xl md:text-6xl text-white mb-6 leading-tight">Проект<br/><span class="italic text-primary-dim">Готов.</span></h3>
                <p class="font-body text-base text-white/80 leading-relaxed uppercase tracking-widest text-[10px]">Финальный Штрих</p>
                <p class="font-body text-lg text-secondary leading-relaxed mt-4">Оставьте контакты, и наш ведущий архитектор свяжется с вами для уточнения деталей производства и доставки.</p>
            </div>
        </div>

        <div class="w-full lg:w-1/2 h-full flex items-center justify-center bg-background px-8 relative">
            <Transition name="fade" mode="out-in">
                <div v-if="!isSubmitted" class="w-full max-w-md lg:max-w-xl" key="form">
                    <div class="bg-surface border border-outline-variant/10 p-10 md:p-16 relative overflow-hidden">
                        <div class="absolute -top-16 -right-16 w-32 h-32 bg-primary/10 rounded-full blur-3xl"></div>
                        
                        <div class="relative z-10">
                            <h2 class="font-headline text-3xl text-on-background mb-2">Финальные Данные</h2>
                            <p class="text-secondary font-body text-sm leading-relaxed mb-8">Укажите контактную информацию. Архитектор свяжется с вами для согласования спецификации из конфигуратора.</p>

                            <div class="mb-10 border border-outline-variant/15 bg-background/60 p-6">
                                <div class="flex items-center justify-between gap-4 mb-5">
                                    <div>
                                        <span class="text-[10px] uppercase tracking-[0.3em] text-primary">Состав заявки</span>
                                        <h3 class="font-headline text-xl text-on-background mt-2">Индивидуальная система</h3>
                                    </div>
                                    <span class="material-symbols-outlined text-primary text-3xl">fact_check</span>
                                </div>

                                <div v-if="isLoadingConfiguration" class="text-sm text-secondary py-4">Загрузка спецификации...</div>
                                <div v-else-if="configuration" class="grid grid-cols-2 gap-px bg-outline-variant/10 text-sm">
                                    <div class="bg-surface p-4">
                                        <div class="text-[10px] uppercase tracking-[0.2em] text-secondary mb-2">Профиль</div>
                                        <div class="text-on-surface font-semibold">{{ configuration.profile?.name || 'Не указан' }}</div>
                                    </div>
                                    <div class="bg-surface p-4">
                                        <div class="text-[10px] uppercase tracking-[0.2em] text-secondary mb-2">Размер</div>
                                        <div class="text-on-surface font-semibold">{{ configuration.width_mm }} x {{ configuration.height_mm }} мм</div>
                                    </div>
                                    <div class="bg-surface p-4">
                                        <div class="text-[10px] uppercase tracking-[0.2em] text-secondary mb-2">Площадь</div>
                                        <div class="text-on-surface font-semibold">{{ area }} м2</div>
                                    </div>
                                    <div class="bg-surface p-4">
                                        <div class="text-[10px] uppercase tracking-[0.2em] text-secondary mb-2">Покрытие</div>
                                        <div class="text-on-surface font-semibold">{{ configuration.material?.name || 'Не указано' }}</div>
                                    </div>
                                </div>
                                <div v-else class="text-sm text-secondary py-4">Заявка будет создана без сохраненной спецификации.</div>

                                <div v-if="enabledAutomation.length" class="mt-5 flex flex-wrap gap-2">
                                    <span v-for="option in enabledAutomation" :key="option.id" class="px-3 py-2 bg-surface-container-high text-primary text-[10px] uppercase tracking-[0.18em] border border-primary/20">
                                        {{ option.name }}
                                    </span>
                                </div>
                            </div>
                            
                            <div v-if="error" class="mb-6 text-sm text-red-400 bg-red-400/10 px-4 py-3 rounded border border-red-400/20">{{ error }}</div>

                            <form @submit.prevent="submitForm" class="space-y-8">
                                <div>
                                    <label for="name" class="block text-[10px] uppercase tracking-[0.3em] text-primary/70 mb-3 font-bold">Имя и Фамилия</label>
                                    <input type="text" id="name" v-model="form.name" required class="w-full bg-background border border-outline-variant/20 px-6 py-5 text-lg font-headline text-on-surface focus:outline-none focus:border-primary transition-colors duration-500 placeholder-outline-variant block" placeholder="Richard Meier" :disabled="isSubmitting" />
                                </div>
                                
                                <div>
                                    <label for="phone" class="block text-[10px] uppercase tracking-[0.3em] text-primary/70 mb-3 font-bold">Контактный Телефон</label>
                                    <input type="tel" id="phone" v-model="form.phone" required class="w-full bg-background border border-outline-variant/20 px-6 py-5 text-lg font-headline text-on-surface focus:outline-none focus:border-primary transition-colors duration-500 placeholder-outline-variant block" placeholder="+7 (999) 000-00-00" :disabled="isSubmitting" />
                                </div>

                                <div class="pt-6">
                                    <button type="submit" :disabled="!form.name || !form.phone || isSubmitting" class="w-full bg-primary text-on-primary py-5 text-xs font-bold uppercase tracking-[0.3em] hover:bg-[#cac6be] hover:text-[#0e0e0e] transition-all duration-500 disabled:opacity-30 disabled:cursor-not-allowed flex justify-between items-center px-8 border border-transparent">
                                        <span>{{ isSubmitting ? 'Отправка...' : 'Подтвердить' }}</span>
                                        <span class="material-symbols-outlined text-base">east</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div v-else class="w-full max-w-md flex flex-col items-center justify-center text-center space-y-8 p-12 bg-surface border border-primary/20 relative overflow-hidden" key="success">
                    <div class="absolute inset-0 bg-[radial-gradient(ellipse_at_center,_var(--tw-gradient-stops))] from-primary/10 via-background/0 to-background/0"></div>
                    <div class="relative z-10 w-24 h-24 rounded-full border border-primary/30 bg-background flex items-center justify-center ring-1 ring-primary/10 ring-offset-8 ring-offset-surface transition-all duration-1000 scale-in mx-auto">
                        <span class="material-symbols-outlined text-4xl text-primary" style="font-variation-settings: 'FILL' 1;">check</span>
                    </div>
                    <div class="relative z-10">
                        <h2 class="font-headline text-3xl text-on-surface mb-3">Заявка Принята</h2>
                        <p class="text-secondary font-body leading-relaxed text-sm">Ваш уникальный проект передан в конструкторский отдел. Ожидайте связи.</p>
                    </div>
                    <button @click="router.push('/')" class="relative z-10 mt-6 border-b border-primary text-primary pb-1 uppercase tracking-[0.2em] hover:text-white hover:border-white transition-colors duration-500 text-[10px] font-bold font-body">На главную</button>
                </div>
            </Transition>
        </div>
    </main>

  </div>
</template>

<style scoped>
input:-webkit-autofill,
input:-webkit-autofill:hover, 
input:-webkit-autofill:focus, 
input:-webkit-autofill:active{
    -webkit-box-shadow: 0 0 0 30px #0f0f0f inset !important;
    -webkit-text-fill-color: #ededed !important;
    transition: background-color 5000s ease-in-out 0s;
}

.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.83, 0, 0.17, 1);
}
.fade-enter-from,
.fade-leave-to {
  opacity: 0;
  transform: translateY(20px);
}

.scale-in {
    animation: scale-up 0.8s cubic-bezier(0.83, 0, 0.17, 1) forwards;
}

@keyframes scale-up {
    0% { transform: scale(0.5); opacity: 0; }
    100% { transform: scale(1); opacity: 1; }
}
</style>
