import VueRouter from 'vue-router';

let routes = [
    {
        path: '/dashboard',
        component: require('./views/dashboard').default
    }
];

import Settings from "../setting/setting.json";
let Pages = Settings.site.pages;

function getRoute (Obj)
{
    return {
        path: '/' + Obj.view,
        component: require('./views/' + Obj.view).default,
        props: {
            name: Obj.name,
            view: Obj.view
        }
    };
}

for (let i in Pages) {
    let Page = Pages[i];
    if (Object.prototype.hasOwnProperty.call(Page, 'pages')) {
        for (let i2 in Page.pages) {
            routes.push(getRoute(Page.pages[i2]));
        }
    } else {
        routes.push(getRoute(Page));
    }
}

export default new VueRouter({
    base: '/admin/',
    mode: 'history',
    routes,
    linkActiveClass: 'active'
});
