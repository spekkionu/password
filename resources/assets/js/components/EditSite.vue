<template>
    <div class="site-edit" style="display:inline-block;">

        <button class="btn btn-success" @click="show">Edit</button>

        <b-modal id="modal-edit" v-model="open" title="Edit Site">
            <slot>
                <div class="form-group" :class="{'has-error': !valid}">
                    <label for="site-name" class="control-label">Name:</label>
                    <input id="site-name" class="form-control" type="text" v-model="name" required>
                </div>
                <div class="form-group">
                    <label for="site-domain" class="control-label">Domain:</label>
                    <input id="site-domain" class="form-control" type="text" v-model="domain">
                </div>
                <div class="form-group">
                    <label for="site-notes" class="control-label">Notes:</label>
                    <textarea id="site-notes" class="form-control" v-model="notes"></textarea>
                </div>
            </slot>
            <div slot="modal-footer">
                <button class="btn btn-secondary" @click="hide">Cancel</button>
                <button :disabled="!valid" class="btn btn-primary" @click="save">Update Site</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex';

    export default {
        data() {
            return {
                open: false,
                name: '',
                domain: '',
                notes: ''
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
                this.name = this.site.name;
                this.domain = this.site.domain;
                this.notes = this.site.notes;
            },
            hide() {
                this.open = false;
                this.name = '';
                this.domain = '';
                this.notes = '';
            },
            save() {
                this.$store.dispatch('updateSite', {
                    'id': this.site.id,
                    'domain': this.domain,
                    'name': this.name,
                    'notes': this.notes
                }).then(() => {
                    this.hide();
                });
            },

            ...mapActions([
                'updateSite'
            ])
        }
    }
</script>
