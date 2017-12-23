<template>
    <div class="site" v-if="site">
        <header>
            <h1 v-text="site.name"></h1>
            <p v-text="site.domain"></p>
            <p style="white-space: pre-wrap;" v-text="site.notes"></p>
        </header>

        <nav class="alert alert-secondary">
            <a class="btn btn-secondary" href="/">Back</a>
            <edit-site></edit-site>
            <delete-site></delete-site>
            <add-section></add-section>
        </nav>

        <div class="site-sections">
            <site-section :section="section" v-for="section in site.sections" :key="section.id"></site-section>
        </div>

    </div>

</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        props: {
            site_id: {
                type: Number,
                required: true
            }
        },
        computed: {

            ...mapGetters([
                'site'
            ])
        },
        methods: {

            ...mapActions([
                'loadSite'
            ])
        },
        mounted() {
            this.$store.dispatch('loadSite', this.site_id);
        }
    }
</script>
