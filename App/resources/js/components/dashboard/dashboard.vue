<template>
    <div class="row">
        <div class="col-md-10 offset-md-1 col-lg-3 offset-lg-0">
            <div class="sidebar">
                <!-- User Widget -->
                <div class="widget user-dashboard-profile">
                    <!-- User Image -->
                    <div class="profile-thumb">
                        <img :src="user.avatar" :alt="user.name" class="rounded-circle">
                    </div>
                    <!-- User Name -->
                    <h5 class="text-center">{{ user.name }}</h5>
                    <p>Unido {{ user.joined }}</p>
                    <a v-if="urlProfile === 'datos-del-cliente'" :href="'#' + urlProfile" class="btn btn-main-sm">Completar
                        Información</a>
                    <a v-else :href="'#' + urlProfile" class="btn btn-main-sm">Editar Perfil</a>
                </div>
                <!-- Dashboard Links -->
                <div class="widget user-dashboard-menu">
                    <ul>
                        <li v-for="url in urls" :key="url.id"
                            :class="url.id === current || ( current === 'new-service-request'  && url.id === 'mis-solicitudes' )? 'active': '' "
                            class="custom-sidebar-item"
                        >
                            <a :href="'#' + url.id" @click.prevent="CHANGE_CURRENT( url.id )">
                                <i class="fa" :class="url.icon"></i> {{ url.name }} <span v-show="url.count > 0">{{ url.count }}</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <comp-customer-data v-if="current === 'datos-del-cliente'"></comp-customer-data>
        <servicerequest v-if="current === 'mis-solicitudes'"></servicerequest>
        <servicerequestform v-if="current === 'new-service-request'"></servicerequestform>
        <sale-quotation-list v-if="current === 'cotizaciones-por-aprobar'" ></sale-quotation-list>
        <sale-quotation-list-approved v-if="current === 'mis-cotizaciones'" ></sale-quotation-list-approved>
        <service v-if="current === 'mis-servicios'"></service>
    </div>
</template>

<script>
    import {mapMutations} from 'vuex'

    export default {
        name: "dashboard",
        created() {
            this.$store.dispatch('loadSettings');
            this.$store.dispatch('loadProducts');
        },
        computed: {
            user() {
                return this.$store.state.Settings.userData;
            },
            urls() {
                return this.$store.state.Settings.urlSettings;
            },
            current() {
                return this.$store.state.Settings.current;
            },
            urlProfile() {
                return this.$store.state.Settings.urlProfile;
            }
        },
        methods: {
            ...mapMutations(['CHANGE_CURRENT'])
        }
    }
</script>

<style scoped>
    .custom-sidebar-item a {
        position: relative;
    }
    .custom-sidebar-item span {
        position: absolute;
        right: 5px;
    }
</style>
