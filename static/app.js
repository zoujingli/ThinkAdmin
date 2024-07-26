;(async () => {
    /*! 项目应用根路径 */
    // @ts-ignore
    window.appRoot = document.querySelector('script[src*="app.js"]').src.split('/').slice(3, -2).join('/') + '/'

    /*! 模块加载请求处理 */
    const options = {
        // 模块缓存
        // @ts-ignore
        moduleCache: { vue: Vue, less: less },
        // 动态加载文件
        getFile(url) {
            if (!/^(https?:)?\/\//) {
                // @ts-ignore
                url = (appRoot + url).replace(/\/+.?\/+/g, '/')
            }
            return fetch(url).then((res) => {
                if (res.ok) {
                    return { getContentData: (binary) => (binary ? res.arrayBuffer() : res.text()) }
                } else if (res.status === 404) {
                    return `<template><el-empty description="${res.status}，${res.statusText}">${url}</el-empty></template>`
                } else {
                    throw Object.assign(new Error(url + ' ' + res.statusText), { res })
                }
            })
        },
        // 追加样式HTML
        addStyle(style) {
            const before = document.head.getElementsByTagName('style')[0] || null
            const object = Object.assign(document.createElement('style'), { textContent: style })
            document.head.insertBefore(object, before)
        },
        // 输出日志信息
        log(type, ...args) {
            console.log(type, ...args)
        },
    }

    const { loadModule } = window['vue3-sfc-loader']
    const loadVue = (vuePath) => loadModule(vuePath, options)

    // @ts-ignore
    const router = VueRouter.createRouter({
        routes: [],
        // @ts-ignore
        history: VueRouter.createWebHashHistory(),
    })

    // 创建后台主路由
    router.addRoute({
        name: 'layout',
        path: '/',
        component: () => {
            return loadVue('/static/template/layout.vue')
        },
        children: [{ path: '/', redirect: '/static/template/login.vue' }],
    })

    // 动态注销路由
    router.afterEach(function (to) {
        let name = to.fullPath.replace(/[.\/]+/g, '_')
        if (router.hasRoute(name)) router.removeRoute(name)
        if (loading) (loading = loading.close()), null
        // @ts-ignore
        document.querySelectorAll('.think-page-loader').forEach((el) => (el.style.display = 'none'))
    })

    // 动态注册路由
    let loading = null
    // @ts-ignore
    router.beforeEach(function (to, fr, next) {
        let name = to.fullPath.replace(/[.\/]+/g, '_')
        if (router.hasRoute(name)) {
            console.log('PAGE-LOADING:', to.fullPath)
            // @ts-ignore
            loading = ElementPlus.ElLoading.service({
                lock: true,
                text: 'Loading',
                background: 'rgba(0, 0, 0, 0.3)',
            })
            next()
        } else {
            // 删除页面缓存
            delete options.moduleCache[to.fullPath]
            // 登录页面处理
            if (to.fullPath.indexOf('/login.vue') > -1) {
                router.addRoute({ name: name, path: to.fullPath, component: () => loadVue(to.fullPath) })
            } else {
                // 动态注册路由并触发新路由
                router.addRoute('layout', { name: name, path: to.fullPath, component: () => loadVue(to.fullPath) })
            }
            next({ name: name })
        }
    })

    // 创建 Vue 应用
    // @ts-ignore
    const app = Vue.createApp({})
    app.directive('href', {
        mounted(el, binding) {
            console.log(el)
            el.addEventListener(
                'click',
                (e) => {
                    e.stopPropagation()
                    if (binding.value) {
                        router.push(binding.value)
                    }
                },
                { passive: false }
            )
        },
        unmounted(el) {
            // 移除点击事件监听器
            el.removeEventListener('click')
        },
    })

    // 定义全局缓存，加载字体组件
    // @ts-ignore
    app.cache = { loadOpt: options, loadVue: loadVue, icons: ElementPlusIconsVue }
    for (let i in app.cache.icons) app.component(i, app.cache.icons[i])

    // 注册 getApp 获取应用
    // @ts-ignore
    window.getApp = () => app

    // 应用组件及路由
    // @ts-ignore
    app.use(ElementPlus).use(router).mount(document.body)
})().catch((ex) => console.error(ex))
