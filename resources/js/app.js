import { createApp } from 'vue'

const modules = import.meta.glob('./Components/**/*.vue')

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-vue]').forEach(async (el) => {
        const componentName = el.dataset.vue
        const module = await modules[`./Components/${componentName}.vue`]()
        createApp(module.default).mount(el)
    })
})