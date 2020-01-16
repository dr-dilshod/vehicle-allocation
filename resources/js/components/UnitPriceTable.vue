<template>
    <div id="app">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block p-1">Back</a>
            </div>
            <div class="col-2">
                <h2 class="text-center text-danger" v-if="this.mode == 'editing'">Editing</h2>
            </div>
            <div class="col-4">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-2"></div>
            <div class="col-2">
                <button class="btn btn-lg btn-danger p-1 pl-2 pr-2" @click="register"
                        :disabled="this.mode != 'editing'">Register
                </button>
                <button class="btn btn-lg btn-danger p-1 pl-3 pr-3" @click="edit">Edit</button>
            </div>
        </div>
        <div class="row align-items-center mt-4">
            <div class="col-md-9 offset-1">
                <div class="form-row form-horizontal">
                    <div class="col-4">
                        <div class="form-group row">
                            <label for="shipperSelect" class="col-4 col-form-label ">Shipper</label>
                            <div class="col-8">
                                <select name="shipper" id="shipperSelect" class="form-control">
                                    <option value="0">-- Select --</option>
                                    <option v-for="shipper in shippers" :value="shipper.shipper_id">{{shipper.shipper_name1 + ' ' + shipper.shipper_name2}}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <button class="btn btn-lg btn-primary btn-block p-1">Search</button>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <button class="btn btn-lg btn-primary btn-block p-1">Clear</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <ejs-grid ref="grid" id="grid" :dataSource="data"
                  :allowSorting="true" :editSettings="editSettings" :height="270"
                  :frozenColumns="6" :toolbar="toolbarBtns">
            <e-columns>
                <e-column field='price_id' headerText='Unit Price ID' width="50" :isPrimaryKey="true"
                          :visible=false></e-column>
                <e-column field='vehicle_type' headerText='Car type'
                          width="100"></e-column>
                <e-column field='shipper_name1' headerText='Shipper'
                          width="100"></e-column>
                <e-column field='stack_point' headerText='Loading port' width="150" ></e-column>
                <e-column field='down_point' headerText='Drop off' width="150" ></e-column>
                <e-column field='type' headerText='Type' width="200" ></e-column>
                <e-column field='price' headerText='Unit price' width="200" ></e-column>
            </e-columns>
        </ejs-grid>

    </div>
</template>

<script>
    import Vue from "vue";
    import {GridPlugin, Sort, Freeze, Toolbar, Edit} from '@syncfusion/ej2-vue-grids';

    Vue.use(GridPlugin);
    export default {
        name: "UnitPriceTable",
        props: {
            backUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
            title: {type: String, required: true}
        },
        data() {
            return {
                mode: 'normal',
                toolbarBtns: null,
                editSettings: {
                    allowEditing: true,
                    allowAdding: true,
                    allowDeleting: true,
                    showDeleteConfirmDialog: true,
                },
                shippers: [],
                data: []
            };
        },
        mounted() {
            this.fetchShipperNames(this.resourceUrl + '/shipper-names');
        },
        methods: {
            register() {
                this.$refs.grid.addRecord();
            },
            edit() {
                this.toolbarBtns = ['Edit', 'Delete', 'Update', 'Cancel'];
                this.mode = 'editing';
                this.editSettings.allowEditing = true;
                this.editSettings.allowDeleting = true;
            },
            fetchShipperNames(url) {
                axios.get(url)
                .then(response => {
                    this.shippers = response.data;
                })
                .catch(err => {
                    alert(err);
                });
            }
        },
        provide: {
            grid: [Sort, Freeze, Edit, Toolbar]
        },
    }
</script>

<style scoped>
    @import "../../../node_modules/@syncfusion/ej2-base/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-vue-grids/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-navigations/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-buttons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-icons/styles/bootstrap.css";
    @import "../../../node_modules/@syncfusion/ej2-popups/styles/bootstrap.css";
</style>
