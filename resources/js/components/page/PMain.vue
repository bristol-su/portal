<template>
    <v-main>
        <v-container fill-height>
            <v-row>
                <v-col>
                    <wrapper v-if="hasConfig" :config="config" :components="config.components">
                        <slot></slot>
                    </wrapper>
                </v-col>
            </v-row>
        </v-container>
    </v-main>
</template>

<script>

import Wrapper from '@/plugins/Wrapper.vue';

export default {
    name: "PMain",
    components: {Wrapper},
    data() {
        return {
            config: null,
        }
    },
    created() {
        window.injector.onModified((config) => {
            this.injectConfig(config);
        })
    },
    mounted() {
        if(window.injector.hasConfig()) {
            this.injectConfig(window.injector.get());
        }
    },
    methods: {
        injectConfig(config) {
            this.config = config;
        }
    },
    computed: {
        hasConfig() {
            return this.config !== null;
        }
    }
}
</script>

<style scoped>

</style>
