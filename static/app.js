;(async () => {
    const options = {
        moduleCache: {
            vue: Vue,
            less: less,
            storage: {}
        },
        getFile(url) {
            return fetch(url).then(res => {
                if (res.ok) {
                    return {getContentData: binary => binary ? res.arrayBuffer() : res.text()};
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
        routes: [],
        history: VueRouter.createWebHashHistory(),
    });

    router.beforeEach(function (to, fr, next) {

        let page = to.fullPath;
        if (to.fullPath === '/') {
            page = './static/template/index.vue';
        }

        const name = page.replace(/[.\/]+/g, '_');
        if (router.hasRoute(name)) {
            next();
        } else {
            router.addRoute({name: name, path: to.fullPath, component: loadVueFile(page)});
            next({name: name});
        }
    });

    router.afterEach(function (to) {
        console.log('afterEach', to);
        if (router.hasRoute(to.fullPath)) {
            router.removeRoute(to.fullPath)
        }
    });

    window.$think = Vue.createApp({
        name: 'ThinkAdmin',
        components: {
            layout: await loadVue('./static/template/layout.vue'),
        }
    });

    // 全局字体文件
    const icons = await loadVue("https://unpkg.com/@element-plus/icons@0.0.11/lib/index.js");
    for (let i in icons) window.$think.component(i, icons[i]);

    window.$think.use(router).use(ElementPlus).mount(document.body);

})().catch(function (ex) {
    console.error(ex);
});