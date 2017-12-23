<template>
    <div class="section-add" style="display:inline-block;">
        <button class="btn btn-success" @click="show">Add Section</button>

        <b-modal id="modal-section-add" v-model="open" title="Add Section">
            <slot>
                <div class="form-group" :class="{'has-error': !valid}">
                    <label for="section-name" class="control-label">Name:</label>
                    <input id="section-name" class="form-control" type="text" v-model="name" required maxlength="191">
                </div>
            </slot>
            <div slot="modal-footer">
                <button class="btn btn-secondary" @click="hide">Cancel</button>
                <button :disabled="!valid" class="btn btn-primary" @click="save">Add Section</button>
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
            show(){
                this.open = true;
            },
            hide(){
                this.open = false;
                this.name = '';
            },
            save(){
                this.$store.dispatch('addSection', {'id': this.site.id, 'name': this.name}).then(() => {
                    this.hide();
                });
            },
            ...mapActions([
                'addSection'
            ])
        }
    }
</script>
