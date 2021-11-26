;(async () => {
    const options = {
        moduleCache: {
            vue: Vue,
            less: less
        },
        getFile(url) {
            return fetch(url).then(res => {
                if (res.ok) return res.text();
                throw Object.assign(new Error(url + ' ' + res.statusText), {res});
            });
        },
        addStyle(textContent) {
            const style = document.head.getElementsByTagName('style')[0] || null;
            const object = Object.assign(document.createElement('style'), {textContent});
            document.head.insertBefore(object, style);
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

    window.app = Vue.createApp({
        name: 'app',
        components: {
            layout: await loadVue('./static/template/layout.vue'),
        }
    });

    // 全局字体文件
    const icons = await loadVue("https://unpkg.com/@element-plus/icons@0.0.11/lib/index.js");
    for (let i in icons) app.component(i, icons[i]);

    app.use(router).use(ElementPlus).mount(document.body);
    
})().catch(function (ex) {
    console.error(ex);
});