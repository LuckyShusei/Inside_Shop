<template>
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <router-link tag="a" to="/dashboard" class="nav-link">
                    <i class="nav-icon fas fa-tachometer-alt" />
                    <p>Dashboard</p>
                </router-link>
            </li>
            <li v-for="item in pages" class="nav-item" :class="item.pages ? 'has-treeview' : ''">
                <router-link
                    v-if="item.view" tag="a" :to="'/'+item.view"
                    class="nav-link"
                    @click.native="reload($route.path === ('/' + item.view))"
                >
                    <i class="nav-icon" :class="item.icon" />
                    <p>{{ item.name }}</p>
                </router-link>
                <!-- tree-view -->
                <a v-if="!item.view" href="#" class="nav-link">
                    <i class="nav-icon" :class="item.icon" />
                    <p>{{ item.name }}</p>
                    <i class="right fas fa-angle-left" />
                </a>
                <ul v-if="item.pages" class="nav nav-treeview ml-2">
                    <li v-for="child in item.pages" class="nav-item ">
                        <router-link
                            v-if="child.view" tag="a" :to="'/'+child.view"
                            class="nav-link"
                            @click.native="reload($route.path === ('/' + child.view))"
                        >
                            <i class="nav-icon" :class="child.icon" />
                            <p>{{ child.name }}</p>
                        </router-link>
                    </li>
                </ul>
                <!-- ./tree-view -->
            </li>
        </ul>
    </nav>
</template>

<script>
    import Settings from '../../../setting/setting.json';

    export default {
        name: "menu-bar",
        data() {
            return {
                pages: Settings.site.pages,
            };
        },
        methods: {
            reload(flag) {
                if (flag) {
                    this.$root.$refs.content.reload();
                }
            }
        }
    }
</script>

<style scoped>

</style>
