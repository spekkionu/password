<template>
    <div class="site-add">
        <nav class="alert alert-secondary">
            <button class="btn btn-success" @click="show">Add</button>
        </nav>

        <b-modal id="modal-add" v-model="open" title="Add Site">
            <slot>
                <div class="form-group" :class="{'has-error': !valid}">
                    <label for="site-name" class="control-label">Name:</label>
                    <input id="site-name" class="form-control" type="text" v-model="name" maxlength="191" required>
                </div>
                <div class="form-group">
                    <label for="site-domain" class="control-label">Domain:</label>
                    <input id="site-domain" class="form-control" type="text" v-model="domain" maxlength="191">
                </div>
                <div class="form-group">
                    <label for="site-notes" class="control-label">Notes:</label>
                    <textarea id="site-notes" class="form-control" v-model="notes"></textarea>
                </div>
            </slot>
            <div slot="modal-footer">
                <button class="btn btn-secondary" @click="hide">Cancel</button>
                <button :disabled="!valid" class="btn btn-primary" @click="save">Add Site</button>
            </div>
        </b-modal>
    </div>
</template>

<script>
    import {mapActions} from 'vuex';

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
            }
        },
        methods: {
            show(){
                this.open = true;
            },
            hide(){
                this.open = false;
                this.name = '';
                this.domain = '';
                this.notes = '';
            },
            save(){
                this.$store.dispatch('addSite', {'domain': this.domain, 'name': this.name, 'notes': this.notes}).then((site) => {
                    window.location = '/site/' + site.id;
                });
            },

            ...mapActions([
                'addSite'
            ])
        }
    }
</script>
