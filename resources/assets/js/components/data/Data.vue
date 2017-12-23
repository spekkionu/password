<template>
    <table class="table table-striped table-bordered table-auto">
        <thead class="thead-light">
        <tr>
            <th colspan="2" v-text="data.name"></th>
        </tr>
        </thead>
        <tr v-for="(row, index) in data.data" :key="index">
            <th v-text="row.label"></th>
            <td v-text="row.value"></td>
        </tr>
        <tfoot>
        <tr>
            <th colspan="2">
                <edit-data :group="data"></edit-data>
                <delete-data :group="data"></delete-data>
            </th>
        </tr>
        </tfoot>
    </table>
</template>

<script>
    import {mapGetters, mapActions} from 'vuex';

    export default {
        props: {
            data: {
                type: Object,
                required: true
            }
        },
        computed: {

            ...mapGetters([
                'site'
            ])
        }
    }
</script>
