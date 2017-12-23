<template>
    <div class="site-delete" style="display:inline-block;">

        <button class="btn btn-danger" @click="show">Delete</button>

        <b-modal id="modal-delete" v-model="open" title="Delete Site">
            <slot>
                <p>
                    Are you sure you want to delete this site?
                </p>
                <p>
                    All data will be lost.
                </p>
            </slot>
            <div slot="modal-footer">
                <button class="btn btn-secondary" @click="hide">Cancel</button>
                <button  class="btn btn-primary" @click="save">Delete Site</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';

    export default {
        data() {
            return {
                open: false
            };
        },
        computed: {

            ...mapGetters([
                'site'
            ])
        },
        methods: {
            show() {
                this.open = true;
            },
            hide() {
                this.open = false;
            },
            save() {
                this.$store.dispatch('deleteSite', this.site.id).then(() => {
                    window.location = '/';
                });
            },

            ...mapActions([
                'deleteSite'
            ])
        }
    }
</script>
