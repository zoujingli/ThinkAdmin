/*! 项目应用根路径 */
window.appRoot = (function (script) {
    let src = script.src.split('/').slice(3);
    return src.pop(), src.pop(), '/' + src.join('/') + '/';
})(document.querySelector('script[src][type=module]:last-child'));

;(async () => {
    const options = {
        moduleCache: {
            vue: Vue,
            less: less
        }, getFile(url) {
            if (!(/^(https?:)?\/\//)) {
                url = (appRoot + url).replace(/\/+.?\/+/g, '/');
            }
            return fetch(url).then(res => {
                if (res.ok) {
                    return {getContentData: binary => binary ? res.arrayBuffer() : res.text()};
                } else if (res.status === 404) {
                    return `<template><el-empty description="${res.status}，${res.statusText}">${url}</el-empty></template>`;
                } else {
                    throw Object.assign(new Error(url + ' ' + res.statusText), {res});
                }
            });
        }, addStyle(style) {
            const before = document.head.getElementsByTagName('style')[0] || null;
            const object = Object.assign(document.createElement('style'), {textContent: style});
            document.head.insertBefore(object, before);
        },
    };

    const {loadModule} = window['vue3-sfc-loader'];
    const loadVue = (vuePath) => loadModule(vuePath, options);
    // const loadVueFile = (vuePath) => () => loadVue(vuePath);
    const router = VueRouter.createRouter({
        routes: [], history: VueRouter.createWebHashHistory(),
    });

    // 添加默认路由
    router.addRoute({path: '/', redirect: '/static/template/pages/one.vue'});

    // 动态注册路由
    let loading = null;
    router.beforeEach(function (to, fr, next) {
        let name = to.fullPath.replace(/[.\/]+/g, '_');
        if (router.hasRoute(name)) {
            console.log('open.load', to.fullPath)
            loading = ElementPlus.ElLoading.service({
                lock: true, text: 'Loading', background: 'rgba(0, 0, 0, 0.3)',
            });
            next();
        } else {
            router.addRoute({name: name, path: to.fullPath, component: () => loadVue(to.fullPath)});
            next({name: name});
        }
    });

    // 动态注销路由
    router.afterEach(function (to) {
        let name = to.fullPath.replace(/[.\/]+/g, '_');
        if (router.hasRoute(name)) {
            router.removeRoute(name)
        }
        if (loading) {
            loading = loading.close(), null;
        }
    });

    // 创建 Vue 应用
    const app = Vue.createApp(Vue.defineAsyncComponent(function () {
        return loadVue('/static/template/layout.vue');
    }));

    // 定义全局缓存
    app.cache = {loadVue: loadVue};

    // 全局字体文件
    app.cache.icons = await loadVue("/static/plugs/core/vue.element.icons.js");
    for (let i in app.cache.icons) app.component(i, app.cache.icons[i]);

    // 注册获取应用
    window.getApp = () => app;

    // 应用组件及路由
    app.use(ElementPlus).use(router).mount(document.body);

})().catch(ex => console.error(ex));