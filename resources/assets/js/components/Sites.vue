<template>
    <div class="sites">

        <add-site></add-site>

        <div class="form-group">
            <input class="form-control" type="search" v-model="search" placeholder="Search">
        </div>

        <div class="alert alert-warning" v-if="filtered.length === 0">
            Your search did not match any results.
        </div>
        <table v-if="filtered.length > 0" class="table table-bordered table-striped">
            <thead class="thead-light">
            <tr>
                <th></th>
                <th>Name</th>
                <th>Domain</th>
            </tr>
            </thead>
            <tr v-for="site in filtered">
                <td>
                    <a class="btn btn-info" :href="'/site/' + site.id">Details</a>
                </td>
                <td v-text="site.name"></td>
                <td v-text="site.domain"></td>
            </tr>
        </table>
    </div>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';
    import fuzzysearch from 'fuzzysearch';

    export default {
        data(){
            return {
                search: ''
            };
        },
        computed: {
            filtered(){
                return _.filter(this.sites, site => {
                    if (this.search === '') {
                        return true;
                    }

                    return fuzzysearch(this.search, site.name) || fuzzysearch(this.search, site.domain);
                });
            },

            ...mapGetters([
                'sites'
            ])
        },
        methods: {
            ...mapActions([
                'loadSites'
            ])
        },
        mounted() {
            this.$store.dispatch('loadSites');
        }
    }
</script>
