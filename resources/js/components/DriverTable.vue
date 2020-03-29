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
                    <button @click="toEditMode" :disabled="editMode" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.edit')}}
                    </button>
                    <button @click="saveData" :disabled="!editMode" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.register')}}
                    </button>
                    <button @click="deleteSelected" :disabled="!editMode" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.delete')}}
                    </button>
                </p>
            </div>
        </div>
        <div id="table-scroll" class="table-scroll">
            <table class="table table-hover table-bordered table-custom-inputs">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sticky-col first-sticky-col">Driver No</th>
                    <th scope="col" class="sticky-col second-sticky-col">Vehicle Type</th>
                    <th scope="col" class="sticky-col third-sticky-col last-sticky-col">Driver Name</th>
                    <th scope="col">Driver Mobile</th>
                    <th scope="col">Vehicle No</th>
                    <th scope="col">Max Load</th>
                    <th scope="col">Search Flg</th>
                    <th scope="col">Admin Flg</th>
                    <th scope="col">Remarks</th>
                    <th scope="col">Password</th>
                    <th scope="col" class="primary-key">Driver Id</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(driver, index) in data" :data-key="driver.driver_id" :index="index" ref="tr"
                    @click="clickRow($event, index)">
                    <td class="sticky-col first-sticky-col">
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model='driver.driver_no' :disabled='!editMode'/></td>
                    <td class="sticky-col second-sticky-col">
                        <select v-on:change="addRowOnChange" class="form-control" v-model="driver.vehicle_type" :disabled="!editMode">
                            <option v-for="type in vehicleTypes" v-bind:value="type.text">
                                {{ type.text }}
                            </option>
                        </select></td>
                    <td class="sticky-col third-sticky-col last-sticky-col">
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="driver.driver_name" :disabled="!editMode"/></td>
                    <td>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="driver.driver_mobile_number" :disabled="!editMode"/></td>
                    <td>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="driver.vehicle_no3" :disabled="!editMode"/></td>
                    <td>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="driver.maximum_Loading" :disabled="!editMode"/></td>
                    <td>
                        <div v-if="editMode">
                            <input v-on:change="addRowOnChange" type="checkbox" class="form-control" v-model="driver.search_flg" :disabled="!editMode"/>
                        </div>
                        <div v-else>
                            <label v-if="driver.search_flg">{{__("driver.hide")}}</label>
                            <label v-else>{{__("driver.show")}}</label>
                        </div>
                    </td>
                    <td>
                        <div v-if="editMode">
                            <input v-on:change="addRowOnChange" type="checkbox" class="form-control" v-model="driver.admin_flg" :disabled="!editMode"/>
                        </div>
                        <div v-else>
                            <label v-if="driver.search_flg">{{__("driver.administrator")}}</label>
                            <label v-else>{{__("driver.user")}}</label>
                        </div>
                        </td>
                    <td>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="driver.driver_remark" :disabled="!editMode"/></td>
                    <td>
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model="driver.driver_pass" :disabled="!editMode"/></td>
                    <td class="primary-key">
                        <input  type="text" class="form-control" v-model="driver.driver_id" :disabled="!editMode"/>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import Vue from "vue";
    import {Query} from '@syncfusion/ej2-data';
    import StickTableMixin from '../utils/StickyTableMixin'

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
        mixins : [
            StickTableMixin
        ],
        data() {
            return {
                data: [],
                vehicleTypes: [
                    {value: "0", text: __('driver.bulk')},
                    {value: "1", text: __('driver.10tw')},
                    {value: "2", text: __('driver.10t_flat')},
                    {value: "3", text: __('driver.4tw')},
                    {value: "4", text: __('driver.4t_flat')},
                    {value: "5", text: __('driver.controller')},
                 ],
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
            }
        },
        mounted() {
            this.fetchData(this.resourceUrl);
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
        name: 'DriverTable'
    }

</script>
