<template>
    <div id="app">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block">{{__('common.back')}}</a>
            </div>
            <div class="col-2">
                <h2 class="text-center text-danger" ref="editTitle">{{__('common.editing')}}</h2>
            </div>
            <div class="col-4">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-2"></div>
            <div class="col-2">
                <p class="text-right">
                    <button class="btn btn-lg btn-danger" ref="registerBtn">{{__('common.register')}}
                    </button>
                    <button class="btn btn-lg btn-danger" ref="editBtn">{{__('common.edit')}}</button>
                </p>
            </div>
        </div>
        <div class="row align-items-center mt-4">
            <div class="col-md-9 offset-1">
                <div class="form-row form-horizontal">
                    <div class="col-4">
                        <div class="form-group row">
                            <label for="shipperSelect"
                                   class="col-4 col-form-label ">{{__('unit_prices.shipper')}}</label>
                            <div class="col-8">
                                <select name="shipper" id="shipperSelect" ref="shipperSelect" class="form-control">
                                    <option value="0">{{__('common.select_input')}}</option>
                                    <option v-for="shipper in shippers" :value="shipper.id">
                                        {{shipper.shipper}}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <button v-on:click="search" class="btn btn-lg btn-primary btn-block p-1">
                                {{__('common.search')}}
                            </button>
                        </div>
                    </div>
                    <div class="col-2">
                        <div class="form-group">
                            <button v-on:click="clear" class="btn btn-lg btn-primary btn-block p-1">
                                {{__('common.clear')}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden" id="resourceUrl" :value="resourceUrl">
        <input type="hidden" id="selectedShipperId" :value="0">
        <ejs-grid ref="grid" id="Grid" :dataSource="data" :rowSelected="rowSelected"
                  :allowSorting="true" :editSettings="editSettings" :height="270"
                  :actionBegin="actionBegin" :toolbar="toolbarBtns">
            <e-columns>
                <e-column field='car_type' :headerText="__('unit_prices.car_type')"
                          editType='dropdownedit'
                          :edit="params.vehicleTypesParams"
                          width="200"></e-column>
                <e-column field='shipper_id' :headerText="__('unit_prices.shipper')" :editTemplate='shipperEditTemplate'
                          width="200"></e-column>
                <e-column field='stack_point' :headerText="__('unit_prices.loading_port')" width="200"></e-column>
                <e-column field='down_point' :headerText="__('unit_prices.drop_off')" width="200"></e-column>
                <e-column field='type' :headerText="__('unit_prices.type')" width="100"></e-column>
                <e-column field='price' :headerText="__('unit_prices.unit_price')" width="100"></e-column>
                <e-column field='price_id' :headerText="__('unit_prices.unit_price_id')" width="5" :isPrimaryKey="true"
                          :visible=false></e-column>
                <e-column field='shipperId' :headerText="__('unit_prices.shipper_id')" width="5"
                          :visible=false></e-column>
            </e-columns>
        </ejs-grid>

    </div>
</template>

<script>
    import Vue from "vue";
    import {Edit, Freeze, GridPlugin, Sort, Toolbar} from '@syncfusion/ej2-vue-grids';
    import {DropDownListPlugin} from '@syncfusion/ej2-vue-dropdowns';
    import {Query} from '@syncfusion/ej2-data';
    import {TableUtil} from "../utils/TableUtil";

    Vue.use(GridPlugin);
    Vue.use(DropDownListPlugin);
    let shippers = [];
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
                tableUtil: null,
                toolbarBtns: null,
                editSettings: {
                    allowEditing: false,
                    allowAdding: false,
                    allowDeleting: false,
                    showDeleteConfirmDialog: true,
                },
                shippers: [],
                vehicle_types: [
                    {
                        "vehicle_type": this.__('unit_prices.car_types.wing'),
                    },
                    {
                        "vehicle_type": this.__('unit_prices.car_types.flat'),
                    },
                    {
                        "vehicle_type": this.__('unit_prices.car_types.trailer'),
                    },
                    {
                        "vehicle_type": this.__('unit_prices.car_types.bulk'),
                    }
                ],
                data: [],
                params: {
                    vehicleTypesParams: {
                        params: {
                            index: -1,
                            allowFiltering: true,
                            dataSource: this.vehicle_types,
                            fields: {text: "vehicle_type", value: "vehicle_type"},
                            query: new Query()
                        }
                    }
                },
                rules: {
                    car_type: {required: [true, this.__('validation.required', {attribute: this.__('unit_prices.car_type')})]},
                    shipper_id: {required: [true, this.__('validation.required', {attribute: this.__('unit_prices.shipper')})]},
                    stack_point: {required: [true, this.__('validation.required', {attribute: this.__('unit_prices.loading_port')})]},
                    down_point: {required: [true, this.__('validation.required', {attribute: this.__('unit_prices.drop_off')})]},
                    type: {
                        required: [true, this.__('validation.required', {attribute: this.__('unit_prices.type')})],
                        number: [true, this.__('validation.numeric', {attribute: this.__('unit_prices.type')})]
                    },
                    price: {
                        required: [true, this.__('validation.required', {attribute: this.__('unit_prices.unit_price')})],
                        number: [true, this.__('validation.numeric', {attribute: this.__('unit_prices.unit_price')})]
                    },
                }
            }
        },
        created() {
            this.fetchShipperNames(`${this.resourceUrl}/shipper-names`);
        },
        mounted() {
            this.tableUtil = new TableUtil(this);
            this.$refs.grid.hideSpinner();
        },
        methods: {
            shipperEditTemplate() {
                return {
                    template: Vue.component('shipperSelectBox', {
                      template: `<select class="form-control" name="shipper_id" @change="onChange($event)">
                                    <option value="0"></option>
                                    <option v-for="shipper in shippers" :value="shipper.id" :selected="Number(shipper.id) === Number(selected)">{{shipper.shipper}}</option>
                                 </select>`,
                        data() {
                          return {
                              data: {},
                              shippers: [],
                              selected: 0,
                              resourceUrl: document.getElementById('resourceUrl').value
                          }
                        },
                        methods: {
                            fetchShipperName(url) {
                                axios.get(url)
                                    .then(response => {
                                        if (response.data.length > 0) {
                                            this.shippers = response.data.map(e => {
                                                return {shipper: e.shipper_name1 + ' ' + e.shipper_name2, id: e.shipper_id};
                                            });
                                            this.selected = document.getElementById('selectedShipperId').value;
                                        }
                                    });
                            },
                            onChange(event) {
                                document.getElementById('selectedShipperId').value = event.target.value;
                                this.selected = document.getElementById('selectedShipperId').value;
                            }
                        },
                        mounted() {
                              this.fetchShipperName(`${this.resourceUrl}/shipper-names`);
                        }
                    })
                };
            },
            search() {
                let id = this.$refs.shipperSelect.value;
                axios.get(`${this.resourceUrl}/?shipper_id=${id}`)
                    .then(response => {
                        if (response.data && response.data.length > 0) {
                            this.data = response.data.map(e => {
                                return {
                                    price_id: e.price_id,
                                    car_type: e.car_type,
                                    shipperId: e.shipper_id,
                                    shipper_id: e.shipper.shipper_name1 + ' ' + e.shipper.shipper_name2,
                                    stack_point: e.stack_point,
                                    down_point: e.down_point,
                                    type: e.type,
                                    price: e.price
                                };
                            });
                            this.$refs.grid.refresh();
                        } else {
                            this.data = [];
                        }
                    });
            },
            clear() {
                this.$refs.shipperSelect.value = 0;
                this.data = [];
                this.$refs.grid.refresh();
            },
            register() {
                this.$refs.grid.addRecord();
            },
            fetchShipperNames(url) {
                axios.get(url)
                    .then(response => {
                        if (response.data.length > 0) {
                            this.shippers = response.data.map(e => {
                                return {shipper: e.shipper_name1 + ' ' + e.shipper_name2, id: e.shipper_id};
                            });
                        }
                    });
            },
            rowSelected: function(args) {
                document.getElementById('selectedShipperId').value = args.data.shipperId;
            },
            insertData(unitPrice) {
                unitPrice.shipper_id = document.getElementById('selectedShipperId').value;
                axios.post(this.resourceUrl, unitPrice)
                    .then(response => {
                        document.querySelector('#shipperSelect [value="' + response.data.shipper_id + '"]').selected = true;
                        this.search();
                        this.tableUtil.endEditing();
                        this.createSuccessDialog();
                    })
                    .catch(error => {
                        this.tableUtil.editFailure();
                        document.getElementById('selectedShipperId').value = unitPrice.shipper_id;
                        this.errorDialog(error);
                    });
            },
            updateData(unitPrice) {
                    unitPrice = unitPrice.data;
                    unitPrice.shipper_id = document.getElementById('selectedShipperId').value;
                axios.post(this.resourceUrl + '/' + unitPrice.price_id, unitPrice)
                    .then(response => {
                        document.querySelector('#shipperSelect [value="' + response.data.shipper_id + '"]').selected = true;
                        this.search();
                        this.updateSuccessDialog();
                    })
                    .catch(error => {
                        this.tableUtil.editFailure();
                        this.errorDialog(error);
                    });
            },
            deleteData(id) {
                axios.delete(this.resourceUrl + '/' + id)
                    .then(response => {
                        this.tableUtil.endEditing();
                        this.deleteSuccessDialog();
                    }).catch(err => {
                    this.tableUtil.editFailure();
                        this.errorDialog(err);
                    });
            },
            actionBegin(args) {
                if (args.requestType === 'save') {
                    if (args.hasOwnProperty('data') && args.data.hasOwnProperty('price_id') && args.data.price_id === undefined) {
                        this.insertData(args.data);
                    } else {
                        this.updateData(args);
                    }
                } else if (args.requestType === 'delete') {
                    if (args.data[0].price_id !== undefined) {
                        this.deleteData(args.data[0].price_id);
                    }
                } else if (args.requestType === 'beginEdit') {
                    this.$refs.grid.getColumnByField('car_type').edit.params.dataSource = this.vehicle_types;
                } else if (args.requestType === 'add') {
                    this.$refs.grid.getColumnByField('car_type').edit.params.dataSource = this.vehicle_types;

                }
            }

        },
        provide: {
            grid: [Sort, Freeze, Edit, Toolbar]
        },
    }
</script>
