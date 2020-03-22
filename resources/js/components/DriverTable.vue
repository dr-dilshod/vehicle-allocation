<template>
    <div id="app">
        <div class="row mb-4">
            <div class="col-2">
                <a @click="back"
                   class="btn btn-lg btn-warning btn-block btn-fixed-width">{{__('common.back')}}</a>
            </div>
            <div class="col-2">
                <h2 ref="editTitle" class="text-center text-danger">{{__('common.editing')}}</h2>
            </div>
            <div class="col-3">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-5">
                <p class="text-right">
                    <button ref="deleteBtn" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.delete')}}
                    </button>
                    <button ref="registerBtn" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.register')}}
                    </button>
                    <button ref="editBtn" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.edit')}}</button>
                </p>
            </div>
        </div>
        <ejs-grid ref="grid" id="grid" :dataSource="data" :actionBegin="actionBegin"
                  :allowSorting="true" :height="300" :frozenColumns="3" :enableHover='false' :allowSelection='true'
                  rowHeight=35>
            <e-columns>
                <e-column field='driver_no' :headerText='__("driver.no")' width="150" type="string"></e-column>
                <e-column field='vehicle_type' :headerText='__("driver.type")' editType='dropdownedit'
                          :edit='vehicleTypeParams' width="150" type="string"></e-column>
                <e-column field='driver_name' :headerText='__("driver.name")' width="150" type="string"></e-column>
                <e-column field='driver_mobile_number' :headerText='__("driver.mobile_number")' width="150" type="string"></e-column>
                <e-column field='vehicle_no3' :headerText='__("driver.vehicle_no")' width="150" type="string"></e-column>
                <e-column field='maximum_Loading' :headerText='__("driver.max_load")' width="100" type="string"></e-column>
                <e-column field='search_flg' :headerText='__("driver.display")' editType='booleanedit'
                          :template='searchTemplate' width="150"></e-column>
                <e-column field='admin_flg' :headerText='__("driver.admin")' editType='booleanedit'
                          :template="adminTemplate" width="150"></e-column>
                <e-column field='driver_remark' :headerText='__("driver.remarks")' width="200" type="string"></e-column>
                <e-column field='driver_pass' :headerText='__("driver.password")' width="200" type="string"></e-column>
                <e-column field='driver_id' :visible="false" :isPrimaryKey="true" width="0"></e-column>
            </e-columns>
        </ejs-grid>
    </div>
</template>

<script>
    import Vue from "vue";
    import {createElement} from '@syncfusion/ej2-base';
    import {DropDownList} from "@syncfusion/ej2-dropdowns";
    import {Query} from '@syncfusion/ej2-data';
    import {GridPlugin, Sort, Freeze, Toolbar, Edit} from '@syncfusion/ej2-vue-grids';
    import {TableUtil} from '../utils/TableUtil.js'

    let vehicleTypes = [
        {vehicleType: __('driver.bulk')},
        {vehicleType: __('driver.10tw')},
        {vehicleType: __('driver.10t_flat')},
        {vehicleType: __('driver.4tw')},
        {vehicleType: __('driver.4t_flat')},
        {vehicleType: __('driver.controller')},
    ];
    Vue.use(GridPlugin);
    export default {
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            fetchUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
            insertUrl: {type: String, required: true},
            updateUrl: {type: String, required: true},
            deleteUrl: {type: String, required: true},
        },
        data() {
            return {
                data: [],
                tableUtil: undefined,
                vehicleTypeParams: {
                    params: {
                        dataSource: vehicleTypes,
                        fields: {text: "vehicleType", value: "vehicleType"},
                        query: new Query(),
                    }
                },
                adminTemplate: function () {
                    return {
                        template: Vue.component('editOption', {
                            template: '<label>{{(data.admin_flg == false)? this.__("driver.user"):this.__("driver.administrator")}}</label>',
                            data() {
                                return {data: {data: {}}};
                            }
                        })
                    }
                },
                searchTemplate: function () {
                    return {
                        template: Vue.component('editOption', {
                            template: '<label>{{(data.search_flg == true)? this.__("driver.show"):this.__("driver.hide")}}</label>',
                            data() {
                                return {data: {data: {}}};
                            }
                        })
                    }
                },
                textTemplate(args){
                    return {
                        template: Vue.component('textTemplate', {
                            template: '<input class="e-field e-input" type="text" v-model="data.driver_no"/>',
                            data() { return { data: {} }}
                        })
                    }
                },
                mode: 'Batch',
                addSuccess: 1,
                changeSuccess: 1,
                deleteSuccess: 1,
            };
        },
        mounted() {
            this.tableUtil = new TableUtil(this);
            this.fetchData(this.resourceUrl);
            // TODO: back button bilan kelishmayapti
            // window.onbeforeunload =  () => {
            //     const data = this.$refs.grid.ej2Instances.getBatchChanges();
            //     if (!_.isEmpty(data) && (data.addedRecords.length > 0 || data.deletedRecords.length > 0 || data.changedRecords.length > 0)) {
            //         return "";
            //     } else {
            //         return null;
            //     }
            // }
        },
        methods: {
            back() {
                const data = this.$refs.grid.ej2Instances.getBatchChanges();
                if (!_.isEmpty(data) && (data.addedRecords.length > 0 || data.deletedRecords.length > 0 || data.changedRecords.length > 0)) {
                    this.$modal.show({
                        template: this.saveChangesTemplate,
                        props: ['title', 'text', 'triggerOnConfirm', 'triggerDiscard']
                    }, {
                        title: window.__('alert.message'),
                        text: this.__('common.save_changes'),
                        triggerOnConfirm: () => {
                            //save changes here
                            this.$modal.hide('confirmDialog');
                            this.tableUtil.endEditing();
                        },
                        triggerDiscard: () => {
                            location.href = this.backUrl;
                        }
                    }, {
                        height: 'auto',
                        width: 400,
                        name: 'confirmDialog'
                    });
                } else {
                    location.href = this.backUrl;
                }
            },
            saveChanges(changedData) {
                this.$modal.show({
                    template: this.saveChangesTemplate,
                    props: ['title', 'text', 'triggerOnConfirm', 'triggerDiscard']
                }, {
                    title: window.__('alert.message'),
                    text: this.__('common.save_changes'),
                    triggerOnConfirm: () => {
                        if (changedData.addedRecords.length > 0) {
                            this.insertData(changedData.addedRecords);
                        }
                        if (changedData.changedRecords.length > 0) {
                            this.editData(changedData.changedRecords);
                        }
                        if (changedData.deletedRecords.length > 0) {
                            this.deleteData(changedData.deletedRecords);
                        }
                        if (this.addSuccess === 1 && this.changeSuccess === 1 && this.deleteSuccess === 1) {
                            this.showOperationSuccessDialog();
                            this.fetchData(this.resourceUrl);
                            this.$refs.grid.ej2Instances.refresh();
                            this.tableUtil.endEditing();
                        } else {
                            this.addSuccess = 1;
                            this.changeSuccess = 1;
                            this.deleteSuccess = 1;
                        }
                        this.$modal.hide('confirmDialog');
                    },
                    triggerDiscard: () => {
                        // discard changes e.g. refresh
                        this.fetchData(this.resourceUrl);
                        this.$refs.grid.ej2Instances.refresh();
                        this.$modal.hide('confirmDialog');
                        this.tableUtil.endEditing();
                    }
                }, {
                    height: 'auto',
                    width: 400,
                    name: 'confirmDialog'
                });

            },

            fetchData(url) {
                axios.get(url)
                    .then(response => {
                        this.data = response.data;
                        for (let i = 0; i < this.data.length; i++) {
                            this.data[i].driver_pass = null;
                            if (this.data[i].search_flg == 0) {
                                this.data[i].search_flg = false;
                            } else {
                                this.data[i].search_flg = true;
                            }
                            if (this.data[i].admin_flg == 1) {
                                this.data[i].admin_flg = true;
                            } else {
                                this.data[i].admin_flg = false;
                            }
                        }
                    })
            },
            actionBegin(args) {
                if (args.requestType == 'save') {
                    args.cancel = true;
                    if (!args.data.driver_id) {
                        args.data.driver_pass = args.data.driver_pass_temp;
                        this.insertData(args.data);
                    } else {
                        if (args.data.driver_pass_temp != null) {
                            args.data.driver_pass = args.data.driver_pass_temp;
                        }
                        this.editData(args.data);
                    }
                }
                if (args.requestType == 'delete') {
                    args.cancel = true;
                    if (args.data[0].driver_id !== undefined) {
                        this.deleteData(args.data[0].driver_id);
                    }
                }
            },
            insertData(createdData) {
                const driver_table = this;
                // if needed, added row without data can be ignored here
                //for (let index = 0; index < createdData.length; index++) {
                //    if (empty(createdData[index].driver_no)) {
                //        createdData.splice(index, 1);
                //    }
                //}
                axios.post(this.insertUrl, createdData)
                    .then(response => {
                        driver_table.addSuccess = 1;
                    })
                    .catch(error => {
                        this.errorDialog(error);
                        driver_table.addSuccess = 0;
                    });
            },
            editData(updatedData) {
                const driver_table = this;
                axios.post(this.updateUrl, updatedData)
                    .then(response => {
                        driver_table.changeSuccess = 1;
                    })
                    .catch(error => {
                        this.errorDialog(error);
                        driver_table.changeSuccess = 0;
                    });
            },
            deleteData(deletedData) {
                const driver_table = this;
                axios.post(this.deleteUrl, deletedData)
                    .then(response => {
                        driver_table.deleteSuccess = 1;
                    })
                    .catch(error => {
                        this.errorDialog(error);
                        driver_table.deleteSuccess = 0;
                    });
            },
            refresh() {
                this.fetchData(this.resourceUrl);
            }
        },
        provide: {
            grid: [Sort, Freeze, Edit]
        },
        name: 'DriverTable'
    }

</script>
