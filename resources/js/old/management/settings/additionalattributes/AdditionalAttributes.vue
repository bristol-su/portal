<template>
    <div>
        <b-row>
            <b-col>
                <h3>Groups, Positions, Roles and Users can all have any number of additional data attributes.</h3>
            </b-col>
        </b-row>

        <b-tabs content-class="mt-3">
            <b-tab active title="Users">
                <additional-attributes-for type="user"></additional-attributes-for>
            </b-tab>
            <b-tab title="Groups">
                <additional-attributes-for type="group"></additional-attributes-for>
            </b-tab>
            <b-tab title="Roles">
                <additional-attributes-for type="role"></additional-attributes-for>
            </b-tab>
            <b-tab title="Positions">
                <additional-attributes-for type="position"></additional-attributes-for>
            </b-tab>
        </b-tabs>


    </div>
</template>

<script>
    import AdditionalAttributesFor from './AdditionalAttributesFor';

    export default {
        name: "AdditionalAttributes",
        components: {AdditionalAttributesFor},
    }
</script>

<style scoped>

</style>
