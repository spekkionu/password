<template>
    <div class="data-delete" style="display:inline-block;">

        <button class="btn btn-danger" @click="show">Delete</button>

        <b-modal id="modal-delete" v-model="open" title="Delete Data Group">
            <slot>
                <p>
                    Are you sure you want to delete this data group?
                </p>
                <p>
                    All data will be lost.
                </p>
            </slot>
            <div slot="modal-footer">
                <button class="btn btn-secondary" @click="hide">Cancel</button>
                <button  class="btn btn-primary" @click="save">Delete Data</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';

    export default {
        props: {
            group: {
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
                this.$store.dispatch('deleteData', {
                    site: this.site.id,
                    section: this.group.section_id,
                    id: this.group.id
                }).then(() => {
                    this.hide();
                });
            },

            ...mapActions([
                'deleteData'
            ])
        }
    }
</script>
