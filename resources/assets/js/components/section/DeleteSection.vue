<template>
    <div class="section-delete" style="display:inline-block;">

        <button class="btn btn-danger" @click="show">Delete</button>

        <b-modal id="modal-delete" v-model="open" title="Delete Section">
            <slot>
                <p>
                    Are you sure you want to delete this section?
                </p>
                <p>
                    All data will be lost.
                </p>
            </slot>
            <div slot="modal-footer">
                <button class="btn btn-secondary" @click="hide">Cancel</button>
                <button  class="btn btn-primary" @click="save">Delete Section</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';

    export default {
        props: {
            section: {
                type: Object,
                required: true
            }
        },
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
                this.$store.dispatch('deleteSection', {site: this.site.id, section: this.section.id}).then(() => {
                    this.hide();
                });
            },

            ...mapActions([
                'deleteSection'
            ])
        }
    }
</script>
