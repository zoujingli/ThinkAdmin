;(async () => {
    const options = {
        moduleCache: {vue: Vue},
        getFile(url) {
            return fetch(url).then(res => {
                if (!res.ok) throw Object.assign(new Error(url + ' ' + res.statusText), {res});
                return res.text();
            })
        },
        addStyle(textContent) {
            document.head.insertBefore(
                Object.assign(document.createElement('style'), {textContent}),
                document.head.getElementsByTagName('style')[0] || null);
        },
    };

    const {loadModule} = window['vue3-sfc-loader'];
    const loadVue = (vuePath) => loadModule(vuePath, options);
    const loadVueFile = (vuePath) => () => loadVue(vuePath);

    const app = Vue.createApp({
        name: 'app',
        components: {'layout': await loadVue('./static/template/layout.vue')}
    });

    const router = VueRouter.createRouter({
        routes: [],
        history: VueRouter.createWebHashHistory(),
    });

    router.beforeEach(function (to, fr, next) {
        console.log(fr.fullPath, '-- to -->', to.fullPath)

        let page = to.fullPath;
        if (to.fullPath === '/') {
            page = './static/template/index.vue';
        }

        if (router.hasRoute(to.fullPath)) {
            next();
        } else {
            router.addRoute({name: to.fullPath, path: to.fullPath, component: loadVueFile(page)});
            next({name: to.fullPath});
        }
    });

    router.afterEach(function (to) {
        if (router.hasRoute(to.fullPath)) {
            router.removeRoute(to.fullPath)
        }
    });

    app.use(ElementPlus).use(router).mount("#app");

})().catch(function (ex) {
    console.error(ex);
});