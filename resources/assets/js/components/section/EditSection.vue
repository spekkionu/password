<template>
    <div class="section-edit" style="display:inline-block;">

        <button class="btn btn-success" @click="show">Edit</button>

        <b-modal id="modal-edit" v-model="open" title="Edit Section">
            <slot>
                <div class="form-group" :class="{'has-error': !valid}">
                    <label for="section-name" class="control-label">Name:</label>
                    <input id="section-name" class="form-control" type="text" v-model="name" required>
                </div>
            </slot>
            <div slot="modal-footer">
                <button class="btn btn-secondary" @click="hide">Cancel</button>
                <button :disabled="!valid" class="btn btn-primary" @click="save">Update Section</button>
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
                open: false,
                name: '',
            };
        },
        computed: {
            valid() {
                return this.name !== '';
            },

            ...mapGetters([
                'site'
            ])
        },
        methods: {
            show() {
                this.open = true;
                this.name = this.section.name;
            },
            hide() {
                this.open = false;
                this.name = '';
            },
            save() {
                this.$store.dispatch('updateSection', {
                    'site': this.site.id,
                    'section': this.section.id,
                    'name': this.name
                }).then(() => {
                    this.hide();
                });
            },

            ...mapActions([
                'updateSection'
            ])
        }
    }
</script>
