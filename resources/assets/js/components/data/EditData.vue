<template>
    <div class="data-edit" style="display:inline-block;">

        <button class="btn btn-success" @click="show">Edit</button>

        <b-modal id="modal-edit" size="lg" v-model="open" title="Edit Data">
            <slot>
                <div class="form-group" :class="{'has-error': !valid}">
                    <label for="data-name" class="control-label">Name:</label>
                    <input id="data-name" class="form-control" type="text" v-model="name" required>
                </div>
                <div class="row" v-for="(row, index) in data">
                    <div class="col-sm-5">
                        <div class="form-group">
                            <label for="data-label" class="control-label">Label:</label>
                            <input id="data-label" class="form-control" type="text" v-model="row.label" maxlength="191">
                        </div>
                    </div>
                    <div class="col-sm-6 col-xs-10">
                        <div class="form-group">
                            <label for="data-value" class="control-label">Value:</label>
                            <input id="data-value" class="form-control" type="text" v-model="row.value" maxlength="191">
                        </div>
                    </div>
                    <div class="col-sm-1 col-xs-2" v-if="data.length > 1">
                        <div class="form-group">
                            <label class="control-label">&nbsp;</label>
                            <button class="btn btn-danger" @click="deleteRow(index)" title="Delete Row">
                                &times;
                            </button>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <button class="btn btn-success" @click="addRow">Add Row</button>
                </div>
            </slot>
            <div slot="modal-footer">
                <button class="btn btn-secondary" @click="hide">Cancel</button>
                <button :disabled="!valid" class="btn btn-primary" @click="save">Update Data</button>
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
                open: false,
                name: '',
                data: [
                    {
                        label: '',
                        value: ''
                    }
                ]
            };
        },
        computed: {
            valid() {
                return this.name !== '' && this.data.length > 0;
            },

            ...mapGetters([
                'site'
            ])
        },
        methods: {
            show() {
                this.open = true;
                this.name = this.group.name;
                this.data = this.group.data;
            },
            hide() {
                this.open = false;
                this.name = '';
                this.data = [
                    {
                        label: '',
                        value: ''
                    }
                ];
            },
            addRow() {
                this.data.push({
                    label: '',
                    value: ''
                })
            },
            deleteRow(index) {
                this.data.splice(index, 1);
            },
            save() {
                this.$store.dispatch('updateData', {
                    site: this.site.id,
                    section: this.group.section_id,
                    id: this.group.id,
                    name: this.name,
                    data: this.data
                }).then(() => {
                    this.hide();
                });
            },

            ...mapActions([
                'updateData'
            ])
        }
    }
</script>
