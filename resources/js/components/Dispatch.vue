<template>
    <div class="container">
        <div class="row">
            <div class="col-2">
                <a :href="backUrl"
                   class="btn btn-lg btn-warning btn-block btn-fixed-width">{{__('common.back')}}</a>
            </div>
            <div class="col-8">
                <h2 class="text-center">{{ title }}</h2>
            </div>
            <div class="col-2 text-right">
                <button id="registerBtn" @click="register" class="btn btn-lg btn-danger btn-fixed-width">
                    {{__('common.register')}}
                </button>
            </div>
        </div>
        <div class="row mt-2 mb-2">
            <div class="col-9 offset-1">
                <form action="#" @submit.prevent="display">
                    <div class="row">
                        <div class="col-5">
                            <div class="form-group d-flex">
                                <label for="dispatch_day" class="mt-2">{{__('dispatch.dispatch_day')}}</label>&nbsp;&nbsp;&nbsp;
                                <datepicker v-model="dispatch_day" id="dispatch_day" name="dispatch_day" :bootstrap-styling="true"
                                            :format="options.weekday" :clear-button="true" :language="options.language.ja"
                                ></datepicker>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <button type="button" class="btn btn-primary btn-fixed-width" id="display" @click.prevent="display">{{__('dispatch.display')}}</button>
                                <button type="button" class="btn btn-primary btn-fixed-width" id="nextDay" @click.prevent="nextDay">{{__('dispatch.next_day')}}</button>
                                <button type="button" class="btn btn-primary btn-fixed-width" id="twoDaysLater" @click.prevent="twoDaysLater">{{__('dispatch.two_days_later')}}
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-2 text-right">
                <button id="printBtn" @click="print" class="btn btn-lg btn-success btn-fixed-width">{{__('dispatch.printing')}}</button>
            </div>
        </div>
        <div class="row">
            <div class="col-2">
                <h5 class="text-center pt-1">{{ firstList.date }}</h5>
                <draggable v-model="firstList.data" group="elems" class="elem-list">
                    <div v-for="item in firstList.data" :key="item.item_id" class="elem" :data-item_id="item.item_id">
                        <strong>{{ item.shipper_name }}</strong> <br>
                        {{ item.down_date }} {{ item.down_time }} <br>
                        {{ item.stack_point }} - {{ item.down_point }} <br>
                        {{ item.weight }}t <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span> <br>
                        {{__('dispatch.remarks')}}: {{ item.remarks }}<br>
                    </div>
                </draggable>
            </div>
            <div class="col-2">
                <h5 class="text-center pt-1">{{ secondList.date }}</h5>
                <draggable v-model="secondList.data" group="elems" class="elem-list">
                    <div v-for="item in secondList.data" :key="item.item_id" class="elem" :data-item_id="item.item_id">
                        <strong>{{ item.shipper_name }}</strong> <br>
                        {{ item.down_date }} {{ item.down_time }} <br>
                        {{ item.down_point }} - {{ item.stack_point }} <br>
                        {{ item.weight }}t <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span> <br>
                        {{__('dispatch.remarks')}}: {{ item.remarks }}<br>
                    </div>
                </draggable>
            </div>
            <div class="col-8">
                <table class="table fixed-header">
                    <thead>
                    <tr>
                        <th style="width: 100px" class="text-center">{{__('dispatch.car_no')}}</th>
                        <th style="width: 150px" class="text-center">{{__('dispatch.driver_name')}}</th>
                        <th style="width: 250px" class="text-center">{{__('dispatch.morning')}}</th>
                        <th style="width: 250px" class="text-center">{{__('dispatch.noon')}}</th>
                        <th style="width: 250px" class="text-center">{{__('dispatch.next_product')}}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(elem, idx) in thirdList" :key="elem.vehicle_no" :data-driver-id="elem.driver_id">
                        <td style="width: 100px">{{elem.vehicle_no}}</td>
                        <td style="width: 150px">
                            <div class="driver">
                                <button type="button" class="close" @click="removeRow(idx, elem)" aria-label="Close">
                                    <span aria-hidden="true" class="text-danger">&times;</span>
                                </button>
                                {{elem.driver_name}}
                            </div>
                        </td>
                        <td style="width: 250px">
                            <draggable :list="elem.morning" group="elems" @change="addMorning" @add="add" ghost-class="new"
                                       style="display: block; min-height: 50px" class="morning" :data-driver-id="elem.driver_id">
                                <div class="elem" v-for="item in elem.morning" :data-item_id="item.item_id">
                                    <button type="button" class="close" @click="removeElem(item.item_id)"
                                            aria-label="Close">
                                        <span aria-hidden="true" class="text-danger">&times;</span>
                                    </button>
                                    <strong>{{ item.shipper_name }}</strong> <br>
                                    {{ item.down_date }} {{ item.down_time }} <br>
                                    {{ item.down_point }} - {{ item.stack_point }} <br>
                                    {{ item.weight }}t <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span> <br>
                                    {{__('dispatch.remarks')}}: {{ item.remarks }}<br>
                                </div>
                            </draggable>
                        </td>
                        <td style="width: 250px">
                            <draggable :list="elem.noon" group="elems" @change="addNoon" ghost-class="new"
                                       style="display: block; min-height: 50px" class="noon" :data-driver-id="elem.driver_id">
                                <div class="elem" v-for="item in elem.noon" :data-item_id="item.item_id">
                                    <button type="button" class="close" @click="removeElem(item.item_id)"
                                            aria-label="Close">
                                        <span aria-hidden="true" class="text-danger">&times;</span>
                                    </button>
                                    <strong>{{ item.shipper_name }}</strong> <br>
                                    {{ item.down_date }} {{ item.down_time }} <br>
                                    {{ item.down_point }} - {{ item.stack_point }} <br>
                                    {{ item.weight }}t <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span> <br>
                                    {{__('dispatch.remarks')}}: {{ item.remarks }}<br>
                                </div>
                            </draggable>
                        </td>
                        <td style="width: 250px">
                            <draggable :list="elem.nextProduct" group="elems" @change="addNextProduct" ghost-class="new"
                                       style="display: block; min-height: 50px" class="next-product" :data-driver-id="elem.driver_id">
                                <div class="elem" v-for="item in elem.nextProduct" :data-item_id="item.item_id">
                                    <button type="button" class="close" @click="removeElem(item.item_id)"
                                            aria-label="Close">
                                        <span aria-hidden="true" class="text-danger">&times;</span>
                                    </button>
                                    <strong>{{ item.shipper_name }}</strong> <br>
                                    {{ item.down_date }} {{ item.down_time }} <br>
                                    {{ item.down_point }} - {{ item.stack_point }} <br>
                                    {{ item.weight }}t <span v-if="item.empty_pl != 1">{{__('dispatch.pl_available')}}</span> <br>
                                    {{__('dispatch.remarks')}}: {{ item.remarks }}<br>
                                </div>
                            </draggable>
                        </td>
                    </tr>
                    </tbody>
                    <tfoot slot="footer">
                    <tr>
                        <td colspan="5">
                            <button data-toggle="modal" data-target="#addDriverModal" class="btn btn-primary btn-fixed-width">{{__('dispatch.add')}}
                            </button>
                        </td>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="modal" id="addDriverModal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-blue">
                        <h5 class="modal-title">{{__('dispatch.add_driver')}}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="">
                            <div class="form-group text-center d-flex justify-content-around">
                                <label for="driverName" class="pt-2">{{__('dispatch.driver_name')}}</label>
                                <input type="text" id="driverName" v-model="driver_search" class="form-control"
                                       style="width: calc(50%)"/>
                                <button class="btn btn-primary">{{__('common.search')}}</button>
                            </div>
                            <div class="driver-list">
                                <div class="row label-row mt-2 mr-2 ml-2 mb-0 pb-2">
                                    <div class="col-2"></div>
                                    <div class="col-4"><strong>{{__('dispatch.car_no')}}</strong></div>
                                    <div class="col-6"><strong>{{__('dispatch.driver_name')}}</strong></div>
                                </div>
                                <div class="driver-data">
                                    <label class="row m-2 label-row" v-for="driver in filteredDrivers">
                                        <div class="col-2 text-center">
                                            <input type="checkbox" v-model="tableDriverList" :value="driver.driver_id">
                                        </div>
                                        <div class="col-4">
                                            {{ driver.vehicle_no3 }}
                                        </div>
                                        <div class="col-6">
                                            {{ driver.driver_name }}
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center mt-2">
                            <button type="button" class="btn btn-modal btn-danger btn-fixed-width" @click="registerDriver">{{__('common.register')}}</button>
                            <button type="button" class="btn btn-modal btn-warning ml-3 btn-fixed-width" data-dismiss="modal">{{__('dispatch.cancel')}}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
    import draggable from 'vuedraggable'
    import Datepicker from "vuejs-datepicker";
    import {en, ja} from 'vuejs-datepicker/dist/locale'

    export default{
        name: 'Dispatch',
        components: {
            draggable,
            Datepicker
        },
        props: {
            backUrl: {type: String, required: true},
            title: {type: String, required: true},
            fetchUrl: {type: String, required: true},
            thirdListUrl: {type: String, required: true},
            pdfUrl: {type: String, required: true},
        },
        data(){
            return {
                drivers: [],
                driver_search: '',
                tableDriverList: [],
                firstList: [],
                secondList: [],
                thirdList: [],
                dispatch_day: '',
                registerPostData: [],
                options: {
                    monthFormat: "yyyy/MM",
                    weekday: "yyyy/MM/dd",
                    language: {
                        en: en,
                        ja: ja
                    },
                },
            };
        },
        methods: {
            addMorning: function (evt) {
                let driver_id = $("div[data-item_id="+evt.added.element.item_id+"]").parent().data('driver-id');
                let postData = {
                    timezone: 1,
                    item_id: evt.added.element.item_id,
                    driver_id: driver_id,
                };
                this.registerPostData.push(postData);
                $('div[data-item_id='+postData.item_id+']').addClass('new');
            },
            addNoon: function (evt) {
                let driver_id = $("div[data-item_id="+evt.added.element.item_id+"]").parent().data('driver-id');
                let postData = {
                    timezone: 2,
                    item_id: evt.added.element.item_id,
                    driver_id: driver_id,
                };
                this.registerPostData.push(postData);
                $('div[data-item_id='+postData.item_id+']').addClass('new');
            },
            addNextProduct: function (evt) {
                let driver_id = $("div[data-item_id="+evt.added.element.item_id+"]").parent().data('driver-id');
                let postData = {
                    timezone: 3,
                    item_id: evt.added.element.item_id,
                    driver_id: driver_id,
                };
                this.registerPostData.push(postData);
                $('div[data-item_id='+postData.item_id+']').addClass('new');
            },
            register(){
                let componentInstance = this;
                if(this.registerPostData.length > 0){
                    axios.post(this.fetchUrl,this.registerPostData)
                    .then(response => {
                        componentInstance.registerPostData = [];
                        componentInstance.createSuccessDialog();
                        componentInstance.display();
                        componentInstance.clearNewClass();
                    })
                    .catch(function (error) {
                        componentInstance.errorDialog(error);
                    });
                }
            },
            registerDriver(){
                let componentInstance = this;
                let data = {
                    firstDate: this.firstList.date,
                    drivers: this.tableDriverList
                };
                axios.post(componentInstance.thirdListUrl,data)
                    .then(data => {
                        componentInstance.thirdList = data.data.dispatches;
                        return true;
                    })
                    .catch(function(error){
                        componentInstance.errorDialog(error);
                    });
                $('#addDriverModal').modal('toggle');
            },
            clearNewClass(){
                $('.fixed-header .elem').removeClass('new');
            },
            print(){
                let date = this.dispatch_day;
                window.location.href = this.pdfUrl + '?date=' + date;
            },
            display(){
                let date = this.dispatch_day;
                let dateString = '';
                if(typeof date === 'object')
                    dateString = date.getFullYear()+'/'+(date.getMonth()+1)+'/'+date.getDate();
                else
                    dateString = date;
                this.fetchLists(dateString);
            },
            nextDay(){
                this.dispatch_day = this.getNextWorkday(new Date(this.dispatch_day),1);
                this.display();
            },
            twoDaysLater(){
                this.dispatch_day = this.getNextWorkday(new Date(this.dispatch_day),2);
                this.display();
            },
            removeRow(id, elem){
                let index = this.tableDriverList.indexOf(elem.driver_id);
                if (index !== -1) this.tableDriverList.splice(index, 1);
                this.thirdList.splice(id, 1);
            },
            removeElem(id){
                let componentInstance = this;
                axios.delete(this.fetchUrl+'/'+id)
                    .then(response => {
                        componentInstance.fetchLists(componentInstance.dispatch_day);
                    })
                    .catch(function(error){
                        componentInstance.errorDialog(error);
                    });
            },
            fetchLists(date){
                let componentInstance = this;
                axios.get(this.fetchUrl+'?date='+date)
                    .then(result => {
                        componentInstance.dispatch_day = result.data.first_list.date;
                        componentInstance.firstList = result.data.first_list;
                        componentInstance.secondList = result.data.second_list;
                        componentInstance.drivers = result.data.drivers;
                        componentInstance.thirdList = result.data.dispatches;
                        componentInstance.tableDriverList = result.data.tableDriverList;
                    })
                    .catch(function (error) {
                        componentInstance.errorDialog(error);
                    });
                ;
            },
            fetchDriverTable(){
                let componentInstance = this;
                axios.get(componentInstance.thirdListUrl)
                    .then(data => {
                        componentInstance.thirdList = data.data;
                    })
                    .catch(function (error) {
                        componentInstance.errorDialog(error);
                    });
            },
            getNextWorkday(d,days=1){
                d.setDate(d.getDate()+days); // tomorrow
                if (d.getDay() == 0) d.setDate(d.getDate()+1);
                return d;
            }
        },
        mounted(){
            this.dispatch_day = this.getNextWorkday(new Date());
            this.display();
        },
        computed: {
            filteredDrivers(){
                return this.drivers.filter((driver) => {
                    return driver.driver_name.match(this.driver_search);
                });
            }
        }
    }
</script>
<style scoped>
    .table {
        background: #fff;
    }
    .fixed-header tbody {
        display: block;
        overflow: auto;
        height: 370px;
        width: 100%;
    }
    .driver-list .driver-data {
        display: block;
        overflow-y: auto;
        overflow-x: hidden;
        height: 150px;
        width: 100%;
    }
    .fixed-header thead tr {
        display: block;
    }
    .table th {
        vertical-align: middle;
    }
    .close {
        display: none;
    }
    .driver:hover .close {
        display: inline;
    }
    .elem:hover .close {
        display: inline;
    }
    .elem {
        background: #dae3f3;
        border-radius: 10px;
        margin: 4px;
        padding: 7px;
        font-size: 12px;
    }
    .new {
        background: #e2f0d9;
    }
    .vdp-datepicker{
        display: inline-block;
    }
    .elem-list {
        background: #fff;
        height: 450px;
        overflow-y: scroll;
    }
    .label-row{
        border-bottom: 1px solid #ced4da;
    }
</style>
