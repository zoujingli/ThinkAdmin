/*! 脚本应用根路径 */
window.appRoot = (function (src) {
    return src.pop(), src.pop(), src.join('/') + '/';
})(document.scripts[document.scripts.length - 1].src.split('/'));

console.log('baseRoot', appRoot)

;(async () => {
    const options = {
        moduleCache: {
            vue: Vue, less: less
        },
        getFile(url) {
            document.get
            console.log('load.file', url)
            return fetch(url).then(res => {
                if (res.ok) {
                    return {getContentData: binary => binary ? res.arrayBuffer() : res.text()};
                } else if (res.status === 404) {
                    return `<template><el-empty description="${res.status}，${res.statusText}">${url}</el-empty></template>`;
                } else {
                    throw Object.assign(new Error(url + ' ' + res.statusText), {res});
                }
            });
        },
        addStyle(style) {
            const before = document.head.getElementsByTagName('style')[0] || null;
            const object = Object.assign(document.createElement('style'), {textContent: style});
            document.head.insertBefore(object, before);
        },
    };

    const {loadModule} = window['vue3-sfc-loader'];
    const loadVue = (vuePath) => loadModule(vuePath, options);
    const loadVueFile = (vuePath) => () => loadVue(vuePath);

    const router = VueRouter.createRouter({
        routes: [], history: VueRouter.createWebHashHistory(),
    });

    // 添加默认路由
    router.addRoute({path: '/', redirect: '/static/template/pages/one.vue'});

    // 路由前置处理
    let loading = null;
    router.beforeEach(function (to, fr, next) {
        console.log(to)
        let name = to.fullPath.replace(/[.\/]+/g, '_');
        if (router.hasRoute(name)) {
            console.log('');
            console.log('load.open', to.fullPath)
            loading = ElementPlus.ElLoading.service({
                lock: true, text: 'Loading', background: 'rgba(0, 0, 0, 0.3)',
            });
            next();
        } else {
            router.addRoute({name: name, path: to.fullPath, component: loadVueFile(to.fullPath)});
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
            console.log('load.done')
            loading.close();
            loading = null;
        }

    });

    // window.$think = Vue.createApp({
    //     // name: 'ThinkAdmin',
    //     components: {
    //         layout: await loadVue('./static/template/layout.vue'),
    //     }
    // });

    const app = Vue.createApp(Vue.defineAsyncComponent(function () {
        return loadVue('./static/template/layout.vue');
    }));

    // 全局字体文件
    // const icons = await loadVue("https://unpkg.com/@element-plus/icons@0.0.11/lib/index.js");
    // for (let i in icons) app.component(i, icons[i]);

    app.use(router).use(ElementPlus).mount(document.body);

})().catch(function (ex) {
    console.error(ex);
});