<template>
    <div>
        <span style="color: black; font-weight: bold">{{moduleLabel}}</span>
        <i class="fa fa-eye green-icon" v-if="visible" :id="btnId('visible')"></i>
        <i class="fa fa-eye-slash red-icon" v-else :id="btnId('hidden')"></i>

        <i class="fa fa-lock-open green-icon" v-if="active" :id="btnId('active')"></i>
        <i class="fa fa-lock red-icon" v-else :id="btnId('inactive')"></i>

        <b-tooltip :target="btnId('visible')" v-if="visible" placement="top" triggers="hover click">Can be seen</b-tooltip>
        <b-tooltip :target="btnId('hidden')" v-else placement="top" triggers="hover click">Cannot be seen (is hidden)</b-tooltip>
        <b-tooltip :target="btnId('active')" v-if="active" placement="right" triggers="hover click">Can be used (is active)</b-tooltip>
        <b-tooltip :target="btnId('inactive')" v-else placement="right" triggers="hover click">Cannot be used (is inactive)</b-tooltip>
    </div>
</template>

<script>
export default {
    name: "ActivityInstanceProgressModuleEntry",
    props: {
        moduleId: {
            required: true,
            type: [String,Number]
        },
        name: {
            required: true,
            type: String
        },
        visible: {
            required: true,
            type: Boolean
        },
        active: {
            required: true,
            type: Boolean
        },
        percentage: {
            required: true,
            type: Number
        }
    },
    methods: {
        btnId(text) {
            return 'module-icon-' + this.moduleId + '-' + text;
        }
    },
    computed: {
        moduleLabel() {
            return this.name + ' (' + this.percentage.toString() + '%)'
        }
    }
}
</script>

<style scoped>
.green-icon {
    color: green;
}
.red-icon {
    color: red;
}
</style>
