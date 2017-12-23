<template>
    <div class="section">
        <h4 v-text="section.name"></h4>
        <nav class="alert alert-secondary">
            <edit-section :section="section"></edit-section>
            <delete-section :section="section"></delete-section>
            <add-data :section="section"></add-data>
        </nav>

        <div class="section-data">
            <data-group :data="data" v-for="data in section.data" :key="data.id"></data-group>
        </div>
    </div>

</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        props: {
            section: {
                type: Object,
                required: true
            }
        },
        computed: {

            ...mapGetters([
                'site'
            ])
        }
    }
</script>
