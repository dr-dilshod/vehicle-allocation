<template>
    <div id="app">
        <div class="row mb-4">
            <div class="col-2">
                <a v-on:click="back" class="btn btn-lg btn-warning btn-block btn-fixed-width">{{__('common.back')}}</a>
            </div>
            <div class="col-2">
                <h2 :hidden="!editMode" class="text-center text-danger">{{__('common.editing')}}</h2>
            </div>
            <div class="col-3">
                <h2 class="text-center">{{title}}</h2>
            </div>
            <div class="col-5">
                <p class="text-right">
                    <button @click="saveConfirmModal" :disabled="!editMode" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.register')}}
                    </button>
                    <button @click="toEditMode" :disabled="editMode" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.edit')}}
                    </button>
                    <button @click="deleteConfirmModal" :disabled="!editMode" class="btn btn-lg btn-danger btn-fixed-width">{{__('common.delete')}}
                    </button>
                </p>
            </div>
        </div>
        <div id="table-scroll" class="table-scroll">
            <table class="table table-custom-inputs">
                <thead class="thead-light">
                <tr>
                    <th scope="col" class="sticky-col first-sticky-col">{{__("driver.no")}}</th>
                    <th scope="col" class="sticky-col second-sticky-col" style="min-width: 40px;">{{__("driver.type")}}</th>
                    <th scope="col" class="sticky-col third-sticky-col last-sticky-col">{{__("driver.name")}}</th>
                    <th scope="col">{{__("driver.mobile_number")}}</th>
                    <th scope="col">{{__("driver.vehicle_no")}}</th>
                    <th scope="col">{{__("driver.max_load")}}</th>
                    <th scope="col">{{__("driver.display")}}</th>
                    <th scope="col">{{__("driver.admin")}}</th>
                    <th scope="col">{{__("driver.remarks")}}</th>
                    <th scope="col">{{__("driver.password")}}</th>
                    <th scope="col" class="primary-key"></th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(driver, index) in data" :data-key="driver.driver_id" :index="index"
                    @click="clickRow($event, index)" :hidden="driver.delete_flg == 1">
                    <td class="sticky-col first-sticky-col">
                        <input v-on:change="addRowOnChange" type="text" class="form-control" v-model='driver.driver_no' :disabled='!editMode'/></td>
                    <td class="sticky-col second-sticky-col" style="min-width: 40px;">
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
                            <input v-on:change="addRowOnChange" type="checkbox" v-model="driver.search_flg" :disabled="!editMode"/>
                        </div>
                        <div v-else>
                            <label v-if="driver.search_flg">{{__("driver.hide")}}</label>
                            <label v-else>{{__("driver.show")}}</label>
                        </div>
                    </td>
                    <td>
                        <div v-if="editMode">
                            <input v-on:change="addRowOnChange" type="checkbox" v-model="driver.admin_flg" :disabled="!editMode"/>
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
    import StickTableMixin from '../utils/StickyTableMixin'

    export default {
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            fetchUrl: {type: String, required: true},
            resourceUrl: {type: String, required: true},
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
                emptyRow : {
                    driver_no : '',
                    vehicle_type : null,
                    driver_name : '',
                    driver_mobile_number : '',
                    vehicle_no3 : '',
                    maximum_Loading : '',
                    search_flg : false,
                    admin_flg : false,
                    driver_remark : '',
                    driver_pass : '',
                    driverPass: '',
                    driver_id : null,
                }
            }
        },
        mounted() {
            this.fetchData(this.fetchUrl);
        },
        methods: {
            back() {
                if (this.isDataChanged()) {
                    this.confirmBack();
                } else {
                    window.location.href = this.backUrl;
                }
            },
             fetchData(url) {
                axios.get(url)
                    .then(response => {
                        this.data = response.data.map(e => {
                            return {
                                driver_no : e.driver_no,
                                vehicle_type : e.vehicle_type,
                                driver_name : e.driver_name,
                                driver_mobile_number : e.driver_mobile_number,
                                vehicle_no3 : e.vehicle_no3,
                                maximum_Loading : e.maximum_Loading,
                                search_flg : e.search_flg,
                                admin_flg : e.admin_flg,
                                driver_remark : e.driver_remark,
                                driver_pass : null,
                                driverPass: e.driver_pass,
                                driver_id : e.driver_id,
                            };
                        });
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
                        this.resetTable(response);
                    })
            },
            refresh() {
                this.editMode = false;
                this.fetchData(this.fetchUrl);
            }
        },
        name: 'DriverTable'
    }

</script>
<style>
    .table-scroll{
        min-height: 400px;
        background-color: #fff;
    }
    .table td > div{
        padding: 0.375rem 0.75rem
    }
    .table .thead-light th{
        background-color: #fff;
    }
</style>
